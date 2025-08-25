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
