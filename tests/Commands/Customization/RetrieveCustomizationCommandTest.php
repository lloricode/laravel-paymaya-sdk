<?php

declare(strict_types=1);

use Lloricode\LaravelPaymaya\Commands\Customization\RetrieveCustomizationCommand;
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

it('retrieve even 404', function () {
    $data = [
        'logoUrl' => '',
        'iconUrl' => '',
        'appleTouchIconUrl' => '',
        'customTitle' => '',
        'colorScheme' => '',
        'redirectTimer' => '',
        'hideReceiptInput' => '',
        'skipResultPage' => '',
        'showMerchantName' => '',
    ];

    MockClient::global([
        RetrieveCustomizationRequest::class => new MockResponse(status: 404),
    ]);

    $rows = [];

    foreach ($data as $field => $value) {
        $rows[] = [$field, is_bool($value) ? ($value ? 'true' : 'false') : $value];
    }

    artisan(RetrieveCustomizationCommand::class)
        ->expectsTable(['Field', 'Value'], $rows)
        ->assertSuccessful();
});

it('handle invalid credentials', function () {

    $errorMessage = mockInvalidCredentials(RetrieveCustomizationRequest::class);

    artisan(RetrieveCustomizationCommand::class)
        ->expectsOutput('Failed retrieve customization: '.$errorMessage)
        ->assertFailed();
});
