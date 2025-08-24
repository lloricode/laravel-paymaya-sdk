<?php

declare(strict_types=1);

use Lloricode\LaravelPaymaya\Commands\Customization\RemoveCustomizationCommand;
use Lloricode\Paymaya\Requests\Customization\RemoveCustomizationRequest;
use Saloon\Exceptions\Request\ClientException;
use Saloon\Exceptions\Request\Statuses\InternalServerErrorException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

use function Pest\Laravel\artisan;

it('delete data', function () {

    $mockClient = MockClient::global([
        RemoveCustomizationRequest::class => new MockResponse(status: 204),
    ]);

    artisan(RemoveCustomizationCommand::class)
        ->expectsOutput('Done deleting customization')
        ->assertSuccessful();

    $mockClient->assertSentCount(1);
});

it('handle invalid credentials', function () {

    mockInvalidCredentials(RemoveCustomizationRequest::class);

    artisan(RemoveCustomizationCommand::class)
        ->assertFailed();
})
    ->throws(ClientException::class, mockInvalidCredentialsMessage());

it('handle unknow error', function () {

    MockClient::global([
        RemoveCustomizationRequest::class => new MockResponse(status: 500),
    ]);

    artisan(RemoveCustomizationCommand::class)
        ->assertFailed();
})
    ->throws(InternalServerErrorException::class, 'Internal Server Error (500) Response: []');
