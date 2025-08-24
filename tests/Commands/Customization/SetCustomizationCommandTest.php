<?php

declare(strict_types=1);

use Lloricode\LaravelPaymaya\Commands\Customization\SetCustomizationCommand;
use Lloricode\Paymaya\Requests\Customization\SetCustomizationRequest;
use Saloon\Exceptions\Request\ClientException;
use Saloon\Exceptions\Request\Statuses\InternalServerErrorException;
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
        SetCustomizationRequest::class => new MockResponse(body: $data),
    ]);

    artisan(SetCustomizationCommand::class)
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
        SetCustomizationRequest::class => new MockResponse(body: $responseError, status: 400),
    ]);

    artisan(SetCustomizationCommand::class)
        ->assertFailed();

})->throws(ClientException::class, 'Bad Request (400) Response: {
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

    mockInvalidCredentials(SetCustomizationRequest::class);

    artisan(SetCustomizationCommand::class)
        ->assertFailed();
})
    ->throws(ClientException::class, mockInvalidCredentialsMessage());

it('handle unknow error', function () {

    MockClient::global([
        SetCustomizationRequest::class => new MockResponse(status: 500),
    ]);

    artisan(SetCustomizationCommand::class)
        ->assertFailed();
})
    ->throws(InternalServerErrorException::class, 'Internal Server Error (500) Response: []');
