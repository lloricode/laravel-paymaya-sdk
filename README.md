# Paymaya SDK for Laravel/Lumen

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lloricode/laravel-paymaya-sdk.svg?style=flat-square)](https://packagist.org/packages/lloricode/laravel-paymaya-sdk)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/lloricode/laravel-paymaya-sdk/Tests?label=tests)](https://github.com/lloricode/laravel-paymaya-sdk/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/lloricode/laravel-paymaya-sdk.svg?style=flat-square)](https://packagist.org/packages/lloricode/laravel-paymaya-sdk)

Paymaya SDK for laravel, it uses [paymaya-sdk-php](https://github.com/lloricode/paymaya-sdk-php).

- [Installation](#installation)
- [Usage](#usage)
    - [Checkout](#checkout)
    - [Webhooks Checkout](#checkout-webhook)

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
use Lloricode\Paymaya\Request\Checkout\Webhook;

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
        Webhook::SUCCESS => 'api/payment-callback/paymaya/success',
        Webhook::FAILURE => 'api/payment-callback/paymaya/failure',
        Webhook::DROPOUT => 'api/payment-callback/paymaya/dropout',
    ],
];
```

## Usage

You can copy the sample to test it.

### Checkout

https://developers.paymaya.com/blog/entry/paymaya-checkout-api-overview

``` php
use Carbon\Carbon;
use Lloricode\Paymaya\Request\Checkout\Amount\AmountDetail;
use Lloricode\Paymaya\Request\Checkout\Amount\Amount;
use Lloricode\Paymaya\Request\Checkout\Buyer\BillingAddress;
use Lloricode\Paymaya\Request\Checkout\Buyer\Buyer;
use Lloricode\Paymaya\Request\Checkout\Buyer\Contact;
use Lloricode\Paymaya\Request\Checkout\Buyer\ShippingAddress;
use Lloricode\Paymaya\Request\Checkout\Checkout;
use Lloricode\Paymaya\Request\Checkout\Item;
use Lloricode\Paymaya\Request\Checkout\MetaData;
use Lloricode\Paymaya\Request\Checkout\RedirectUrl;
use Lloricode\Paymaya\Request\Checkout\TotalAmount;

$checkout = (new Checkout())
    ->setTotalAmount(
        (new TotalAmount())
            ->setValue(100)
            ->setDetails(
                (new AmountDetail())
                    ->setSubtotal(100)
            )
    )
    ->setBuyer(
        (new Buyer())
            ->setFirstName('John')
            ->setMiddleName('Paul')
            ->setLastName('Doe')
            ->setBirthday(Carbon::parse('1995-10-24'))
            ->setCustomerSince(Carbon::parse('1995-10-24'))
            ->setGender('M')
            ->setContact(
                (new Contact())
                    ->setPhone('+639181008888')
                    ->setEmail('merchant@merchantsite.com')
            )
            ->setShippingAddress(
                (new ShippingAddress())
                    ->setFirstName('John')
                    ->setMiddleName('Paul')
                    ->setLastName('Doe')
                    ->setPhone('+639181008888')
                    ->setEmail('merchant@merchantsite.com')
                    ->setLine1('6F Launchpad')
                    ->setLine2('Reliance Street')
                    ->setCity('Mandaluyong City')
                    ->setState('Metro Manila')
                    ->setZipCode('1552')
                    ->setCountryCode('PH')
                    ->setShippingType('ST')
            )
            ->setBillingAddress(
                (new BillingAddress())
                    ->setLine1('6F Launchpad')
                    ->setLine2('Reliance Street')
                    ->setCity('Mandaluyong City')
                    ->setState('Metro Manila')
                    ->setZipCode('1552')
                    ->setCountryCode('PH')
            )
    )
    ->addItem(
        (new Item())
            ->setName('Canvas Slip Ons')
            ->setQuantity(1)
            ->setCode('CVG-096732')
            ->setDescription('Shoes')
            ->setAmount(
                (new Amount())
                    ->setValue(100)
                    ->setDetails(
                        (new AmountDetail())
                            ->setDiscount(0)
                            ->setServiceCharge(0)
                            ->setShippingFee(0)
                            ->setTax(0)
                            ->setSubtotal(100)
                    )
            )
            ->setTotalAmount(
                (new Amount())
                    ->setValue(100)
                    ->setDetails(
                        (new AmountDetail())
                            ->setDiscount(0)
                            ->setServiceCharge(0)
                            ->setShippingFee(0)
                            ->setTax(0)
                            ->setSubtotal(100)
                    )
            )
    )
    ->setRedirectUrl(
        (new RedirectUrl())
            ->setSuccess('https://www.merchantsite.com/success')
            ->setFailure('https://www.merchantsite.com/failure')
            ->setCancel('https://www.merchantsite.com/cancel')
    )->setRequestReferenceNumber('1551191039')
    ->setMetadata(
        (new MetaData())
            ->setSMI('smi')
            ->setSMN('smn')
            ->setMCI('mci')
            ->setMPC('mpc')
            ->setMCO('mco')
            ->setMST('mst')
    );

$checkoutResponse = \PaymayaSDKCheckoutClient::execute($checkout);

echo 'id: '.$checkoutResponse->checkoutId."\n";
echo 'url: '.$checkoutResponse->redirectUrl."\n";
```

### Checkout Webhook

```
# see config `paymaya-sdk.webhooks` array to set your webhooks,
# then run this to register webhooks.
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
