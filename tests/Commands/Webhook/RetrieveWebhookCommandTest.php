<?php

declare(strict_types=1);

use Lloricode\LaravelPaymaya\Commands\Webhook\RetrieveWebhookCommand;
use Lloricode\Paymaya\Requests\Webhook\RetrieveWebhookRequest;
use Saloon\Exceptions\Request\ClientException;
use Saloon\Exceptions\Request\Statuses\InternalServerErrorException;
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

    mockInvalidCredentials(RetrieveWebhookRequest::class);

    artisan(RetrieveWebhookCommand::class)
        ->assertFailed();
})
    ->throws(ClientException::class, mockInvalidCredentialsMessage());

it('handle unknow error', function () {

    MockClient::global([
        RetrieveWebhookRequest::class => new MockResponse(status: 500),
    ]);

    artisan(RetrieveWebhookCommand::class)
        ->assertFailed();
})
    ->throws(InternalServerErrorException::class, 'Internal Server Error (500) Response: []');
