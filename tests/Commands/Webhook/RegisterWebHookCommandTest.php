<?php

declare(strict_types=1);

use Lloricode\LaravelPaymaya\Commands\Webhook\CreateWebHookCommand;
use Lloricode\Paymaya\Requests\Webhook\CreateWebhookRequest;
use Lloricode\Paymaya\Requests\Webhook\DeleteWebhookRequest;
use Lloricode\Paymaya\Requests\Webhook\GetWebhookAllRequest;
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
            GetWebhookAllRequest::class => new MockResponse(body: $sampleData),
            DeleteWebhookRequest::class => new MockResponse(status: 204),
            CreateWebhookRequest::class => new MockResponse(body: $sampleData),
        ]);

        artisan(CreateWebHookCommand::class)
            ->expectsOutput('Done registering webhooks')
            ->assertSuccessful();
    }
);

it(
    'register data eve 404',
    function () {

        $sampleData = [sampleWebhookData()];

        MockClient::global([
            GetWebhookAllRequest::class => new MockResponse(status: 404),
            DeleteWebhookRequest::class => new MockResponse(status: 204),
            CreateWebhookRequest::class => new MockResponse(body: $sampleData),
        ]);

        artisan(CreateWebHookCommand::class)
            ->expectsOutput('Done registering webhooks')
            ->assertSuccessful();
    }
);

it('handle invalid credentials', function () {

    mockInvalidCredentials(GetWebhookAllRequest::class);

    artisan(CreateWebHookCommand::class)
        ->assertFailed();
})
    ->throws(ClientException::class, mockInvalidCredentialsMessage());

it('handle unknow error', function () {

    MockClient::global([
        GetWebhookAllRequest::class => new MockResponse(status: 500),
    ]);

    artisan(CreateWebHookCommand::class)
        ->assertFailed();
})
    ->throws(InternalServerErrorException::class, 'Internal Server Error (500) Response: []');
