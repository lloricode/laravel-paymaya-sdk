# laravel-paymaya-sdk

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lloricode/laravel-paymaya-sdk.svg?style=flat-square)](https://packagist.org/packages/lloricode/laravel-paymaya-sdk)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/lloricode/laravel-paymaya-sdk/run-tests?label=tests)](https://github.com/lloricode/laravel-paymaya-sdk/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/lloricode/laravel-paymaya-sdk.svg?style=flat-square)](https://packagist.org/packages/lloricode/laravel-paymaya-sdk)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/package-laravel-paymaya-sdk-laravel.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/package-laravel-paymaya-sdk-laravel)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can
support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require lloricode/laravel-paymaya-sdk
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Lloricode\LaravelPaymaya\LaravelPaymayaServiceProvider" --tag="laravel-paymaya-sdk-config"
```

This is the contents of the published config file:

```php
<?php

use Lloricode\Paymaya\PaymayaClient;
use Lloricode\Paymaya\Request\Checkout\WebhookRequest;

return [
    'mode' => env('PAYMAYA_MODE', PaymayaClient::ENVIRONMENT_SANDBOX),
    'keys' => [
        'public' => env('PAYMAYA_PUBLIC_KEY', ''),
        'secret' => env('PAYMAYA_SECRET_KEY', ''),
    ],

    /**
     *
     * Webhooks
     *
     */
    'webhooks' => [
        WebhookRequest::SUCCESS => url('api/payment-callback/paymaya/success'),
        WebhookRequest::FAILURE => url('api/payment-callback/paymaya/failure'),
        WebhookRequest::DROPOUT => url('api/payment-callback/paymaya/dropout'),
    ],
];

```

## Usage

### webhooks

```
# register webhooks
php artisan paymaya-sdk:webhook:register

# retrieve webhooks
php artisan paymaya-sdk:webhook:retrieve

# retrieve output
+--------+------------------+------------------------------+---------------------+---------------------+
| id     | name             | callbackUrl                  | createdAt           | updatedAt           |
+--------+------------------+------------------------------+---------------------+---------------------+
| <uuid> | CHECKOUT_SUCCESS | http://localhost/api/success | 2021-02-05 17:40:40 | 2021-02-05 17:40:40 |
| <uuid> | CHECKOUT_FAILURE | http://localhost/api/failed  | 2021-02-05 17:40:45 | 2021-02-05 17:40:45 |
| <uuid> | CHECKOUT_DROPOUT | http://localhost/api/dropout | 2021-02-05 17:40:45 | 2021-02-05 17:40:45 |
+--------+------------------+------------------------------+---------------------+---------------------+

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Lloric Mayuga Garcia](https://github.com/lloricode)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
