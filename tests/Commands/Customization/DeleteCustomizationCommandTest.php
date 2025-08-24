<?php

declare(strict_types=1);

use Lloricode\LaravelPaymaya\Commands\Customization\DeleteCustomizationCommand;
use Lloricode\Paymaya\Requests\Customization\DeleteCustomizationRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

use function Pest\Laravel\artisan;

it('delete data', function () {

    $mockClient = MockClient::global([
        DeleteCustomizationRequest::class => new MockResponse(status: 204),
    ]);

    artisan(DeleteCustomizationCommand::class)
        ->expectsOutput('Done deleting customization')
        ->assertSuccessful();

    $mockClient->assertSentCount(1);
});

it('handle invalid credentials', function () {

    $errorMessage = mockInvalidCredentials(DeleteCustomizationRequest::class);

    artisan(DeleteCustomizationCommand::class)
        ->expectsOutput('Failed deleting customization: '.$errorMessage)
        ->assertFailed();
});
