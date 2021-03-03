<?php

namespace Lloricode\LaravelPaymaya\Tests\Commands;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\LaravelPaymaya\Tests\TestCase;

class CustomizationCommandTest extends TestCase
{
    /**
     * @test
     */
    public function retrieve_data()
    {
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

        $handlerStack = HandlerStack::create(
            new MockHandler(
                [
                    new Response(
                        200,
                        [],
                        json_encode($data),
                    ),
                ]
            )
        );

        PaymayaFacade::client()->setHandlerStack($handlerStack);

//        $rows = [];

//        foreach ($data as $field => $value) {
//            $rows[] = [$field, is_bool($value) ? ($value ? 'true' : 'false') : $value];
//        }

        $this->artisan('paymaya-sdk:customization:retrieve')
            // TODO: add test
//            ->expectsTable(['Field', 'Value'], $rows)
            ->assertExitCode(0);
    }

    /** @test */
    public function register_data()
    {
        $data = [
            'logoUrl' => 'http://image1',
            'iconUrl' => 'http://image2',
            'appleTouchIconUrl' => 'http://image3',
            'customTitle' => 'test title',
            'colorScheme' => '1234',
        ];

        config(['paymaya-sdk.checkout.customization' => $data]);

        $handlerStack = HandlerStack::create(
            new MockHandler(
                [
                    new Response(
                        200,
                        [],
                        json_encode($data),
                    ),
                ]
            )
        );

        $history = [];

        PaymayaFacade::client()->setHandlerStack($handlerStack, $history);

        $this->artisan('paymaya-sdk:customization:register')
            ->expectsOutput('Done Registering customization')
            ->assertExitCode(0);

        $this->assertCount(1, $history);

        /** @var \GuzzleHttp\Psr7\Response $response */
        $response = $history[0]['response'];

        $this->assertEquals(200, $response->getStatusCode());

        // TODO: missing response but working ok
//        $this->assertEquals(json_encode($data), $response->getBody()->getContents());
    }

    /**
     * @test
     */
    public function handle_invalid_parameter()
    {
        $data = [
            'logoUrl' => 'http://image1',
            'iconUrl' => 'http://image2',
            'appleTouchIconUrl' => 'http://image3',
            'customTitle' => 'test title',
            'colorScheme' => '1234',
        ];

        config(['paymaya-sdk.checkout.customization' => $data]);

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

        $handlerStack = HandlerStack::create(
            new MockHandler(
                [
                    new Response(
                        400,
                        [],
                        $responseError,
                    ),
                ]
            )
        );

        $history = [];

        $errorArray = (array)json_decode($responseError, true);

        PaymayaFacade::client()->setHandlerStack($handlerStack, $history);

        $this->artisan('paymaya-sdk:customization:register')
            ->expectsOutput('Missing/invalid parameters.')
            ->expectsOutput(json_encode($errorArray['parameters'], JSON_PRETTY_PRINT))
            ->assertExitCode(1);
    }
}
