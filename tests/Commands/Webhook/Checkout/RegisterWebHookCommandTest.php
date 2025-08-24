<?php

declare(strict_types=1);

use Lloricode\LaravelPaymaya\Commands\Webhook\Checkout\RegisterWebHookCommand;
use Lloricode\Paymaya\Requests\Webhook\DeleteWebhookRequest;
use Lloricode\Paymaya\Requests\Webhook\RegisterWebhookRequest;
use Lloricode\Paymaya\Requests\Webhook\RetrieveWebhookRequest;
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

it('handle invalid credentials', function () {

    $errorMessage = mockInvalidCredentials(RetrieveWebhookRequest::class);

    artisan(RegisterWebHookCommand::class)
        ->expectsOutput('Failed registering webhooks: '.$errorMessage)
        ->assertFailed();
});
