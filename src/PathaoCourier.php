<?php

namespace Enan\PathaoCourier;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;


class PathaoCourier extends PathaoBaseAPI
{
    public function getStores()
    {
        $url = "aladdin/api/v1/stores";
        $data = $this->Pathao_API_Response(true, $url, 'get');

        return $data;
    }

    public function getCities()
    {
        $url = "aladdin/api/v1/countries/1/city-list";
        $data = $this->Pathao_API_Response(true, $url, 'get');

        return $data;
    }

    public function getZones(int $city_id)
    {
        $url = "aladdin/api/v1/cities/" . $city_id . "/zone-list";
        $data = $this->Pathao_API_Response(true, $url, 'get');

        return $data;
    }

    public function getAreas(int $zone_id)
    {
        $url = "aladdin/api/v1/zones/" . $zone_id . "/area-list";
        $data = $this->Pathao_API_Response(true, $url, 'get');

        return $data;
    }

    public function createOrder(array $data)
    {
        $validator = Validator::make($data, [
            'store_id'            => ['required', 'numeric'], // Find in store list,
            'merchant_order_id'   => ['required', 'numeric'], // Unique order id
            'recipient_name'      => ['required', 'string'], // Customer name
            'recipient_phone'     => ['required', 'string'], // Customer phone
            'recipient_address'   => ['required', 'string'], // Customer address
            'recipient_city'      => ['required', 'numeric'], // Find in city method
            'recipient_zone'      => ['required', 'numeric'], // Find in zone method
            'recipient_area'      => ['required', 'numeric'], // Find in Area method
            'delivery_type'       => [
                'required',
                'in:' . parent::DELIVERY_TYPE_NORMAL . ',' . parent::DELIVERY_TYPE_DEMAND
            ], // 48 for normal delivery or 12 for on demand delivery
            'item_type'           => [
                'required',
                'in:' . parent::ITEM_TYPE_DOCUMENT . ',' . parent::ITEM_TYPE_PARCEL
            ], // 1 for document, 2 FOR PERCEL
            'special_instruction' => ['nullable', 'string'],
            'item_quantity'       => ['nullable', 'numeric'], // item quantity
            'item_weight'         => ['nullable', 'numeric'], // parcel weight
            'amount_to_collect'   => ['required', 'numeric'], // amount to collect
            'item_description'    => ['nullable', 'string'] // product details
        ]);

        $url = "aladdin/api/v1/orders";

        $body = [
            "store_id" => $data['store_id'],
            "merchant_order_id" => $data['merchant_order_id'],
            "sender_name" => $data['recipient_name'],
            "sender_phone" => $data['recipient_name'],
            "recipient_name" => $data['recipient_name'],
            "recipient_phone" => $data['recipient_phone'],
            "recipient_address" =>  $data['recipient_address'],
            "recipient_city" => $data['recipient_city'],
            "recipient_zone" => $data['recipient_zone'],
            "recipient_area" => $data['recipient_area'],
            "delivery_type" => $data['delivery_type'],
            "item_type" => $data['item_type'],
            "special_instruction" => $data['special_instruction'],
            "item_quantity" =>  $data['item_quantity'],
            "item_weight" => $data['item_weight'],
            "amount_to_collect" => $data['amount_to_collect'],
            "item_description" => $data['item_description'],
        ];

        $data = $this->Pathao_API_Response(true, $url, 'post', $body);

        return $data;
    }

    public function viewOrder(Model $order)
    {
        $consignment_id = $order->pathaoOrder?->consignment_id;
        if ($consignment_id) {
            $url = "aladdin/api/v1/orders/" . $consignment_id;

            $data = $this->Pathao_API_Response(true, $url, 'get');

            return $data;
        }
    }
}
