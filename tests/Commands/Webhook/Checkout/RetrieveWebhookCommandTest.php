<?php

declare(strict_types=1);

use Lloricode\LaravelPaymaya\Commands\Webhook\Checkout\RetrieveWebhookCommand;
use Lloricode\Paymaya\Requests\Webhook\RetrieveWebhookRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

use function Pest\Laravel\artisan;

it('retrieve data', function () {
    $sampleData = [sampleWebhookData()];

    MockClient::global([
        RetrieveWebhookRequest::class => new MockResponse(body: $sampleData),
    ]);

    artisan(RetrieveWebhookCommand::class)
        ->expectsTable(
            [
                'id',
                'name',
                'callbackUrl',
                'createdAt',
                'updatedAt',
            ],
            $sampleData
        )
        ->assertSuccessful();
});
it('retrieve even 404', function () {

    MockClient::global([
        RetrieveWebhookRequest::class => new MockResponse(status: 404),
    ]);

    artisan(RetrieveWebhookCommand::class)
        ->expectsTable(
            [
                'id',
                'name',
                'callbackUrl',
                'createdAt',
                'updatedAt',
            ],
            []
        )
        ->assertSuccessful();
});

it('handle invalid credentials', function () {

    $errorMessage = mockInvalidCredentials(RetrieveWebhookRequest::class);

    artisan(RetrieveWebhookCommand::class)
        ->expectsOutput('Failed retrieve webhooks: '.$errorMessage)
        ->assertFailed();
});

it('handle unknow error', function () {

    MockClient::global([
        RetrieveWebhookRequest::class => new MockResponse(status: 500),
    ]);

    artisan(RetrieveWebhookCommand::class)
        ->expectsOutput('Failed retrieve webhooks: unknown')
        ->assertFailed();
});
