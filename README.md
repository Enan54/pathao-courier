# A complete Laravel Package for Pathao Courier

[![Latest Version on Packagist](https://img.shields.io/packagist/v/enan/pathao-courier.svg?style=flat-square)](https://packagist.org/packages/enan/pathao-courier)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/enan/pathao-courier/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/enan/pathao-courier/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/enan/pathao-courier/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/enan/pathao-courier/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/enan/pathao-courier.svg?style=flat-square)](https://packagist.org/packages/enan/pathao-courier)

This is a laravel package for [Merchant Pathao Courier](https://merchant.pathao.com/) to create order. Now this package is supporting only with one store. Creating new store and create new order with them will be in newer version.

## Support us

## Installation

You can install the package via composer:

```bash
composer require enan/pathao-courier
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="pathao-courier-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="pathao-courier-config"
```

This is the contents of the published config file:

```php
return [
    'pathao_base_url' => 'https://api-hermes.pathao.com/',
    'pathao_client_id' => env('PATHAO_CLIENT_ID', ''),
    'pathao_client_secret' => env('PATHAO_CLIENT_SECRET', ''),
    'pathao_store_id' => env('PATHAO_STORE_ID', ''),
    'pathao_store_name' => env('PATHAO_STORE_NAME', ''),
];
```

<!-- Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="pathao-courier-views"
``` -->

Set the below value in your **.env** file

## .env

```
PATHAO_CLIENT_ID=
PATHAO_CLIENT_SECRET=
PATHAO_STORE_ID=
PATHAO_STORE_NAME=
```

## Usage

```php
$pathaoCourier = new Enan\PathaoCourier();
echo $pathaoCourier->echoPhrase('Hello, Enan!');
```

<!-- ## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities. -->

## Credits

-   [Moammer Farshid Enan](https://github.com/Enan)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Check me on

-   [Portfolio](https://moammer-enan.com/)
-   [Facebook](https://www.facebook.com/moammerfarshidenan)
-   [GitHub](https://github.com/enuenan)
-   [LinkedIn](https://www.linkedin.com/in/moammer-farshid/)
