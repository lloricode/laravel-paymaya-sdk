<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Tests\Commands;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Lloricode\LaravelPaymaya\Commands\Webhook\Checkout\RegisterWebHookCommand;
use Lloricode\LaravelPaymaya\Commands\Webhook\Checkout\RetrieveWebhookCommand;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\Request\Webhook\Webhook;

use function Pest\Laravel\artisan;

it('retrieve data', function () {
    $handlerStack = HandlerStack::create(
        new MockHandler(
            [
                new Response(
                    200,
                    [],
                    json_encode([sampleWebhookData()]),
                ),
            ]
        )
    );

    PaymayaFacade::client()->setHandlerStack($handlerStack);

    artisan(RetrieveWebhookCommand::class)
        ->expectsTable(
            [
                'id',
                'name',
                'callbackUrl',
                'createdAt',
                'updatedAt',
            ],
            [sampleWebhookData()]
        )
        ->assertExitCode(0);
});

it(
    'register data',
    function () {
        $handlerStack = HandlerStack::create(
            new MockHandler(
                [
                    new Response( // retrieve
                        200,
                        [],
                        json_encode(
                            [
                                sampleWebhookData(),
                            ],
                        ),
                    ),
                    new Response( // delete response
                        200,
                        [],
                        json_encode(
                            sampleWebhookData(
                                [
                                    'name' => Webhook::CHECKOUT_SUCCESS,
                                    'id' => 'test-generated-id1',
                                ]
                            ),
                        ),
                    ),
                    new Response(
                        200,
                        [],
                        json_encode(
                            sampleWebhookData(
                                [
                                    'name' => Webhook::CHECKOUT_SUCCESS,
                                    'id' => 'test-generated-id1',
                                ]
                            ),
                        ),
                    ),
                    new Response(
                        200,
                        [],
                        json_encode(
                            sampleWebhookData(
                                [
                                    'name' => Webhook::CHECKOUT_FAILURE,
                                    'id' => 'test-generated-id2',
                                ]
                            ),
                        ),
                    ),
                    new Response(
                        200,
                        [],
                        json_encode(
                            sampleWebhookData(
                                [
                                    'name' => Webhook::CHECKOUT_DROPOUT,
                                    'id' => 'test-generated-id3',
                                ]
                            ),
                        ),
                    ),
                ]
            )
        );

        PaymayaFacade::client()->setHandlerStack($handlerStack);

        artisan(RegisterWebHookCommand::class)
            ->expectsOutput('Done registering webhooks')
            ->assertExitCode(0);
    }
);
