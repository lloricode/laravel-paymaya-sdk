<?php

declare(strict_types=1);

use Lloricode\Paymaya\Enums\Webhook;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

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

function mockInvalidCredentials(string $request): string
{
    $errorMessage = 'Invalid authentication credentials. Kindly verify if the key you are using is correct.';

    MockClient::global([
        $request => new MockResponse(body: [
            'error' => $errorMessage,
            'code' => 'K003',
            'reference' => 'uuid-sample',
        ], status: 401),
    ]);

    return $errorMessage;
}
