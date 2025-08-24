<?php

declare(strict_types=1);

use Lloricode\LaravelPaymaya\Commands\Customization\DeleteCustomizationCommand;
use Lloricode\LaravelPaymaya\Commands\Customization\RegisterCustomizationCommand;
use Lloricode\LaravelPaymaya\Commands\Customization\RetrieveCustomizationCommand;
use Lloricode\Paymaya\Requests\Customization\DeleteCustomizationRequest;
use Lloricode\Paymaya\Requests\Customization\RegisterCustomizationRequest;
use Lloricode\Paymaya\Requests\Customization\RetrieveCustomizationRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

use function Pest\Laravel\artisan;

it('retrieve data', function () {
    $data = [
        'logoUrl' => 'https://image-logo.png',
        'iconUrl' => 'https://image-icon.png',
        'appleTouchIconUrl' => 'https://image-apple.png',
        'customTitle' => 'Test Title Mock',
        'colorScheme' => '#e01c44',
        'redirectTimer' => 3,
        'hideReceiptInput' => true,
        'skipResultPage' => false,
        'showMerchantName' => true,
    ];

    MockClient::global([
        RetrieveCustomizationRequest::class => new MockResponse(body: $data),
    ]);

    $rows = [];

    foreach ($data as $field => $value) {
        $rows[] = [$field, is_bool($value) ? ($value ? 'true' : 'false') : $value];
    }

    artisan(RetrieveCustomizationCommand::class)
        ->expectsTable(['Field', 'Value'], $rows)
        ->assertSuccessful();
});

it('register data', function () {
    $data = [
        'logoUrl' => 'http://image1',
        'iconUrl' => 'http://image2',
        'appleTouchIconUrl' => 'http://image3',
        'customTitle' => 'test title',
        'colorScheme' => '1234',
    ];

    config(['paymaya-sdk.checkout.customization' => $data]);

    $mockClient = MockClient::global([
        RegisterCustomizationRequest::class => new MockResponse(body: $data),
    ]);

    artisan(RegisterCustomizationCommand::class)
        ->expectsOutput('Done registering customization')
        ->assertSuccessful();

    $mockClient->assertSentCount(1);

});

it('handle invalid parameter', function () {

    config(['paymaya-sdk.checkout.customization' => [
        'logoUrl' => 'http://image1',
        'iconUrl' => 'http://image2',
        'appleTouchIconUrl' => 'http://image3',
        'customTitle' => 'test title',
        'colorScheme' => '1234',
    ]]);

    $responseError = '{
    "code": "2553",
    "message": "Missing\/invalid parameters.",
    "parameters": [
        {
            "field": "logoUrl",
            "description": "Must be a valid url of length 5-2082, if specified; required if isPageCustomized is true and if setting at least one other customization."
        },
        {
            "field": "iconUrl",
            "description": "Must be a valid url of length 5-2082, if specified; required if isPageCustomized is true and if setting at least one other customization."
        },
        {
            "field": "appleTouchIconUrl",
            "description": "Must be a valid url of length 5-2082, if specified; required if isPageCustomized is true and if setting at least one other customization."
        }
    ]
}';

    $mockClient = MockClient::global([
        RegisterCustomizationRequest::class => new MockResponse(body: $responseError, status: 400),
    ]);

    $errorArray = (array) json_decode($responseError, true);

    artisan(RegisterCustomizationCommand::class)
        ->expectsOutput('Missing/invalid parameters.')
        ->expectsOutput(json_encode($errorArray['parameters'], JSON_PRETTY_PRINT))
        ->assertFailed();

});

it('delete data', function () {

    $mockClient = MockClient::global([
        DeleteCustomizationRequest::class => new MockResponse(status: 204),
    ]);

    artisan(DeleteCustomizationCommand::class)
        ->expectsOutput('Done deleting customization')
        ->assertSuccessful();

    $mockClient->assertSentCount(1);
});
