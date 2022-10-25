<?php

declare(strict_types=1);

use Lloricode\Paymaya\Request\Webhook\Webhook;

function sampleWebhookData(array $override = []): array
{
    return $override + [
        'id' => 'test-generated-id',
        'name' => Webhook::CHECKOUT_SUCCESS,
        'callbackUrl' => 'https://web.test/test/success',
        'createdAt' => 'Sun Jan 05 2020 02:30:57 GMT+0000',
        'updatedAt' => 'Sun Jan 05 2020 02:30:57 GMT+0000',
    ];
}
