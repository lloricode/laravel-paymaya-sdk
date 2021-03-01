<?php

use Lloricode\Paymaya\PaymayaClient;
use Lloricode\Paymaya\Request\Webhook\Webhook;

return [
    'mode' => env('PAYMAYA_MODE', PaymayaClient::ENVIRONMENT_SANDBOX),
    'keys' => [
        'public' => env('PAYMAYA_PUBLIC_KEY'),
        'secret' => env('PAYMAYA_SECRET_KEY'),
    ],

    /**
     *
     * Webhooks
     *
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
            'logoUrl' => 'http://testimge1',
            'iconUrl' => 'http://testimge1',
            'appleTouchIconUrl' => 'http://testimge1',
            'customTitle' => 'test paymaya sandbox title',
            'colorScheme' => '#e01c44',
        ],
    ],
];
