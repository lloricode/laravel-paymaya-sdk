<?php

declare(strict_types=1);

use Lloricode\LaravelPaymaya\Commands\Customization\RegisterCustomizationCommand;
use Lloricode\Paymaya\Requests\Customization\RegisterCustomizationRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

use function Pest\Laravel\artisan;

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

    MockClient::global([
        RegisterCustomizationRequest::class => new MockResponse(body: $responseError, status: 400),
    ]);


    artisan(RegisterCustomizationCommand::class)
        ->expectsOutput('Missing/invalid parameters.')
        ->assertFailed();

})->throws('Bad Request (400) Response: {
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
}');

it('handle invalid credentials', function () {

    mockInvalidCredentials(RegisterCustomizationRequest::class);

    artisan(RegisterCustomizationCommand::class)
        ->assertFailed();
})
    ->throws(mockInvalidCredentialsMessage());

it('handle unknow error', function () {

    MockClient::global([
        RegisterCustomizationRequest::class => new MockResponse(status: 500),
    ]);

    artisan(RegisterCustomizationCommand::class)
        ->assertFailed();
})
    ->throws('Internal Server Error (500) Response: []');
