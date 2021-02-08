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
        WebhookRequest::SUCCESS => 'api/payment-callback/paymaya/success',
        WebhookRequest::FAILURE => 'api/payment-callback/paymaya/failure',
        WebhookRequest::DROPOUT => 'api/payment-callback/paymaya/dropout',
    ],
];
