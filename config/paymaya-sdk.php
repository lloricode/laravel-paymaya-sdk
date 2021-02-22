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
