<?php

declare(strict_types=1);

use Lloricode\LaravelPaymaya\Commands\Webhook\RegisterWebHookCommand;
use Lloricode\Paymaya\Requests\Webhook\DeleteWebhookRequest;
use Lloricode\Paymaya\Requests\Webhook\RegisterWebhookRequest;
use Lloricode\Paymaya\Requests\Webhook\RetrieveWebhookRequest;
use Saloon\Exceptions\Request\ClientException;
use Saloon\Exceptions\Request\Statuses\InternalServerErrorException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

use function Pest\Laravel\artisan;

it(
    'register data',
    function () {

        $sampleData = [sampleWebhookData()];

        MockClient::global([
            RetrieveWebhookRequest::class => new MockResponse(body: $sampleData),
            DeleteWebhookRequest::class => new MockResponse(status: 204),
            RegisterWebhookRequest::class => new MockResponse(body: $sampleData),
        ]);

        artisan(RegisterWebHookCommand::class)
            ->expectsOutput('Done registering webhooks')
            ->assertSuccessful();
    }
);

it(
    'register data eve 404',
    function () {

        $sampleData = [sampleWebhookData()];

        MockClient::global([
            RetrieveWebhookRequest::class => new MockResponse(status: 404),
            DeleteWebhookRequest::class => new MockResponse(status: 204),
            RegisterWebhookRequest::class => new MockResponse(body: $sampleData),
        ]);

        artisan(RegisterWebHookCommand::class)
            ->expectsOutput('Done registering webhooks')
            ->assertSuccessful();
    }
);

it('handle invalid credentials', function () {

    mockInvalidCredentials(RetrieveWebhookRequest::class);

    artisan(RegisterWebHookCommand::class)
        ->assertFailed();
})
    ->throws(ClientException::class, mockInvalidCredentialsMessage());

it('handle unknow error', function () {

    MockClient::global([
        RetrieveWebhookRequest::class => new MockResponse(status: 500),
    ]);

    artisan(RegisterWebHookCommand::class)
        ->assertFailed();
})
    ->throws(InternalServerErrorException::class, 'Internal Server Error (500) Response: []');
