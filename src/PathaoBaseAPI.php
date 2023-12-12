<?php

namespace Enan\PathaoCourier;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class PathaoBaseAPI
{
    protected $base_url = config('pathao-courier.pathao_base_url');
    protected $client;
    protected $client_id = config('pathao-courier.pathao_client_id');
    protected $client_secret = config('pathao-courier.pathao_client_secret');
    protected $refresh_token = config('pathao-courier.patha');
    protected $grant_type;
    const DELIVERY_TYPE_NORMAL = 48;
    const DELIVERY_TYPE_DEMAND = 12;
    const ITEM_TYPE_DOCUMENT = 1;
    const ITEM_TYPE_PARCEL = 2;

    public function __construct()
    {
        if (auth()->user()->store) {
            $checkAccessTokenIsValid = $this->checkAccessTokenIsValid();
            // If access token is not valid request for a new token.
            if (!$checkAccessTokenIsValid) {
                $this->requestAccesstoken();
            }
        }

        $this->client = new Client([
            'base_uri' => $this->base_url,
        ]);
    }

    protected function setHeaders(bool $auth = false)
    {
        $headers = [
            "accept" => "application/json",
            "content-type" => 'application/json',
        ];

        if ($auth) {
            $headers["authorization"] = "Bearer " . auth()->user()->store->pathao->token;
        };

        return $headers;
    }

    public function getAccessToken(array $cred)
    {
        $url = "aladdin/api/v1/issue-token";
        $data = $this->Pathao_API_Response(false, $url, 'post', $cred);

        return $data;
    }

    public function Pathao_API_Response(bool $auth = false, string $api, string $method, ?array $data = [])
    {
        try {
            $response = $this->client->{$method}(
                $api,
                [
                    'headers' => $this->setHeaders($auth),
                    'body' => ($method == 'post') ? json_encode($data) : null
                ]
            );

            $statusCode = $response->getStatusCode();

            $responseData = json_decode($response->getBody());
            $data = [
                'code' => $statusCode,
                'status' => 'success',
                'data' => $responseData,
            ];
        } catch (ClientException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            $responseBody = $e->getResponse()->getBody()->getContents();

            $errorData = json_decode($responseBody);
            Log::error("API Error: Status Code $statusCode - Response: $responseBody");

            $data = [
                'code' => $statusCode,
                'status' => 'failed',
                'message' => $errorData->message,
            ];
        }

        return (object)$data;
    }

    public function checkAccessTokenIsValid(): bool
    {
        $currentTimestamp = time();
        $expirationTime = auth()->user()->store->expires_in;

        // Compare the expiration time with the current time
        return $expirationTime <= $currentTimestamp;
    }

    public function requestAccesstoken()
    {
        $cred = [
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret,
            "refresh_token" => $this->refresh_token,
            "grant_type" => $this->grant_type
        ];
        $response = $this->getAccessToken($cred);

        if ($response->code == 200) {
            return auth()->user()->store->pathao->update([
                'token' => $response->data->access_token,
                'refresh_token' => $response->data->refresh_token,
                'expires_in' => time() + $response->data->expires_in
            ]);
        } else {
            return $response->data;
        }
    }
}
