# Paymaya SDK for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lloricode/laravel-paymaya-sdk.svg?style=flat-square)](https://packagist.org/packages/lloricode/laravel-paymaya-sdk)
[![Tests](https://github.com/lloricode/laravel-paymaya-sdk/actions/workflows/run-tests.yml/badge.svg)](https://github.com/lloricode/laravel-paymaya-sdk/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/lloricode/laravel-paymaya-sdk.svg?style=flat-square)](https://packagist.org/packages/lloricode/laravel-paymaya-sdk)
[![codecov](https://codecov.io/gh/lloricode/laravel-paymaya-sdk/branch/main/graph/badge.svg?token=JXRH9XB4BL)](https://codecov.io/gh/lloricode/laravel-paymaya-sdk)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/donate?hosted_button_id=V8PYXUNG6QP44)


[![ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/D1D71HJZD)

Paymaya SDK for laravel, it uses [lloricode/paymaya-sdk-php](https://github.com/lloricode/paymaya-sdk-php).

- [Installation](#installation)
- [Usage](#usage)
    - [Checkout](#checkout)
    - [Webhooks](#webhook)
    - [Testing with Saloon Client Mock](#testing-with-saloon-client-mock)

## Installation

You can install the package via composer:

```bash
composer require lloricode/laravel-paymaya-sdk
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Lloricode\LaravelPaymaya\LaravelPaymayaServiceProvider" --tag="paymaya-sdk-config"
```

This is the contents of the published config file:

```php
<?php

declare(strict_types=1);

use Lloricode\Paymaya\Enums\Environment;
use Lloricode\Paymaya\Enums\Webhook;

/**
 * @todo: Manage Exception using laravel logs, allow set config log files
 */

return [
    'mode' => env('PAYMAYA_MODE', Environment::Sandbox->value),
    'keys' => [
        'public' => env('PAYMAYA_PUBLIC_KEY'),
        'secret' => env('PAYMAYA_SECRET_KEY'),
    ],

    /**
     * Webhooks
     */
    'webhooks' => [
        Webhook::CHECKOUT_SUCCESS => 'api/payment-callback/paymaya/success',
        Webhook::CHECKOUT_FAILURE => 'api/payment-callback/paymaya/failure',
        Webhook::CHECKOUT_DROPOUT => 'api/payment-callback/paymaya/dropout',

        //        Webhook::PAYMENT_SUCCESS => 'api/test/success',
        //        Webhook::PAYMENT_EXPIRED => 'api/test/expired',
        //        Webhook::PAYMENT_FAILED => 'api/test/failed',
    ],

    'checkout' => [
        'customization' => [
            'logoUrl' => 'https://image1.png',
            'iconUrl' => 'https://image2.png',
            'appleTouchIconUrl' => 'https://image3.png',
            'customTitle' => 'test paymaya sandbox title',
            'colorScheme' => '#e01c44',
            'redirectTimer' => 3,
            //            'hideReceiptInput' => true,
            //            'skipResultPage' => false,
            //            'showMerchantName' => true,
        ],
    ],
];

```

## Usage

You can copy the sample to test it.

### Checkout
https://developers.maya.ph/reference/createv1checkout

``` php
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\DataTransferObjects\Checkout\Amount\AmountDetailDto;
use Lloricode\Paymaya\DataTransferObjects\Checkout\Amount\AmountDto;
use Lloricode\Paymaya\DataTransferObjects\Checkout\Buyer\BillingAddressDto;
use Lloricode\Paymaya\DataTransferObjects\Checkout\Buyer\BuyerDto;
use Lloricode\Paymaya\DataTransferObjects\Checkout\Buyer\ContactDto;
use Lloricode\Paymaya\DataTransferObjects\Checkout\Buyer\ShippingAddressDto;
use Lloricode\Paymaya\DataTransferObjects\Checkout\CheckoutDto;
use Lloricode\Paymaya\DataTransferObjects\Checkout\ItemDto;
use Lloricode\Paymaya\DataTransferObjects\Checkout\MetaDataDto;
use Lloricode\Paymaya\DataTransferObjects\Checkout\RedirectUrlDto;
use Lloricode\Paymaya\DataTransferObjects\Checkout\TotalAmountDto;

$checkout = new CheckoutDto(
    totalAmount: new TotalAmountDto(
        value: 100,
        details: new AmountDetailDto(
            subtotal: 100
        )
    ),
    buyer: new BuyerDto(
        firstName: 'John',
        middleName: 'Paul',
        lastName: 'Doe',
        birthday: '1995-10-24',
        customerSince: '1995-10-24',
        gender: 'M',
        contact: new ContactDto(
            phone: '+639181008888',
            email: 'merchant@merchantsite.com'
        ),
        shippingAddress: new ShippingAddressDto(
            firstName: 'John',
            middleName: 'Paul',
            lastName: 'Doe',
            phone: '+639181008888',
            email: 'merchant@merchantsite.com',
            line1: '6F Launchpad',
            line2: 'Reliance Street',
            city: 'Mandaluyong City',
            state: 'Metro Manila',
            zipCode: '1552',
            countryCode: 'PH',
            shippingType: 'ST'
        ),
        billingAddress: new BillingAddressDto(
            line1: '6F Launchpad',
            line2: 'Reliance Street',
            city: 'Mandaluyong City',
            state: 'Metro Manila',
            zipCode: '1552',
            countryCode: 'PH'
        )
    ),
    items: [
        new ItemDto(
            name: 'Canvas Slip Ons',
            quantity: 1,
            code: 'CVG-096732',
            description: 'Shoes',
            amount: new AmountDto(
                value: 100,
                details: new AmountDetailDto(
                    discount: 0,
                    serviceCharge: 0,
                    shippingFee: 0,
                    tax: 0,
                    subtotal: 100
                )
            ),
            totalAmount: new AmountDto(
                value: 100,
                details: new AmountDetailDto(
                    discount: 0,
                    serviceCharge: 0,
                    shippingFee: 0,
                    tax: 0,
                    subtotal: 100
                )
            )
        ),
    ],
    redirectUrl: new RedirectUrlDto(
        success: 'https://www.merchantsite.com/success',
        failure: 'https://www.merchantsite.com/failure',
        cancel: 'https://www.merchantsite.com/cancel'
    ),
    requestReferenceNumber: '1551191039',
    metadata: new MetaDataDto(
        smi: 'smi',
        smn: 'smn',
        mci: 'mci',
        mpc: 'mpc',
        mco: 'mco',
        mst: 'mst'
    )
);

// submit
$checkoutResponse = PaymayaFacade::createCheckout($checkout);

echo 'id: '.$checkoutResponse->checkoutId."\n";
echo 'url: '.$checkoutResponse->redirectUrl."\n";

// retrieve
PaymayaFacade::getCheckout($checkoutResponse->checkoutId);
```

### Webhook
https://developers.maya.ph/reference/createv1webhook-1
```
# see config `paymaya-sdk.webhooks` array to set your webhooks,
# then run this to create webhooks.

php artisan paymaya-sdk:webhook:create


# get all webhooks

php artisan paymaya-sdk:webhook:all


# retrieve output

+--------+------------------+------------------------------+---------------------+---------------------+
| id     | name             | callbackUrl                  | createdAt           | updatedAt           |
+--------+------------------+------------------------------+---------------------+---------------------+
| <uuid> | CHECKOUT_SUCCESS | http://localhost/api/success | 2021-02-05 17:40:40 | 2021-02-05 17:40:40 |
| <uuid> | CHECKOUT_FAILURE | http://localhost/api/failed  | 2021-02-05 17:40:45 | 2021-02-05 17:40:45 |
| <uuid> | CHECKOUT_DROPOUT | http://localhost/api/dropout | 2021-02-05 17:40:45 | 2021-02-05 17:40:45 |
+--------+------------------+------------------------------+---------------------+---------------------+

```

### Testing with Saloon Client Mock
Sample usage of client mock
https://docs.saloon.dev/the-basics/testing

```php
    
    use Lloricode\Paymaya\Requests\Checkout\CreateCheckoutRequest;
    use Saloon\Http\Faking\MockClient;
    use Saloon\Http\Faking\MockResponse;

    /**
     * @test
     */
    public function success_checkout() 
    {
            $paymayaID = 'test-paymaya-generated-id';
            $paymayaRedirectUrl = 'http://test-paymaya/redirect-url';
    
            MockClient::global([
                CreateCheckoutRequest::class => new MockResponse(
                    body: [
                        'checkoutId' => $paymayaID,
                        'redirectUrl' => $paymayaRedirectUrl,
                    ]
                ),
            ]);
            
           // your test
          

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
