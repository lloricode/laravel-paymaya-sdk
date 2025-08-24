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

function mockInvalidCredentials(string $request): void
{

    MockClient::global([
        $request => new MockResponse(body: [
            'error' => 'Invalid authentication credentials. Kindly verify if the key you are using is correct.',
            'code' => 'K003',
            'reference' => 'uuid-sample',
        ], status: 401),
    ]);

}

function mockInvalidCredentialsMessage(): string
{
    return 'Unauthorized (401) Response: {"error":"Invalid authentication credentials. Kindly verify if the key you are using is correct.","code":"K003","reference":"uuid-sample"}';
}
