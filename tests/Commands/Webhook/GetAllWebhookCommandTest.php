<?php

declare(strict_types=1);

use Lloricode\LaravelPaymaya\Commands\Webhook\GetAllWebhookCommand;
use Lloricode\Paymaya\Requests\Webhook\GetAllWebhookRequest;
use Saloon\Exceptions\Request\ClientException;
use Saloon\Exceptions\Request\Statuses\InternalServerErrorException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

use function Pest\Laravel\artisan;

it('retrieve data', function () {
    $sampleData = [sampleWebhookData()];

    MockClient::global([
        GetAllWebhookRequest::class => new MockResponse(body: $sampleData),
    ]);

    artisan(GetAllWebhookCommand::class)
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
        GetAllWebhookRequest::class => new MockResponse(status: 404),
    ]);

    artisan(GetAllWebhookCommand::class)
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

    mockInvalidCredentials(GetAllWebhookRequest::class);

    artisan(GetAllWebhookCommand::class)
        ->assertFailed();
})
    ->throws(ClientException::class, mockInvalidCredentialsMessage());

it('handle unknow error', function () {

    MockClient::global([
        GetAllWebhookRequest::class => new MockResponse(status: 500),
    ]);

    artisan(GetAllWebhookCommand::class)
        ->assertFailed();
})
    ->throws(InternalServerErrorException::class, 'Internal Server Error (500) Response: []');
