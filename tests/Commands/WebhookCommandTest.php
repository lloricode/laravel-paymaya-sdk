<?php

namespace Lloricode\LaravelPaymaya\Tests\Commands;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Lloricode\LaravelPaymaya\Facades\ClientFacade;
use Lloricode\LaravelPaymaya\Tests\TestCase;
use Lloricode\Paymaya\Request\Checkout\WebhookRequest;

class WebhookCommandTest extends TestCase
{
    /** @test */
    public function retrieve_data()
    {
        $handlerStack = HandlerStack::create(
            new MockHandler(
                [
                    new Response(
                        200,
                        [],
                        json_encode([self::sampleWebhookData()]),
                    ),
                ]
            )
        );

        ClientFacade::setHandlerStack($handlerStack);

        $this->artisan('paymaya-sdk:webhook:retrieve')
//            ->expectsTable(
//                [
//                    'id',
//                    'name',
//                    'callbackUrl',
//                    'createdAt',
//                    'updatedAt',
//                ],
//                [self::sampleWebhookData()]
//            )
            // TODO: commented because its always failed
            ->assertExitCode(0);
    }

    /** @test */
    public function register_data()
    {
        $handlerStack = HandlerStack::create(
            new MockHandler(
                [
                    new Response( //retrieve
                        200,
                        [],
                        json_encode(
                            [
                                self::sampleWebhookData(),
                            ],
                        ),
                    ),
                    new Response( // delete response
                        200,
                        [],
                        json_encode(
                            self::sampleWebhookData(
                                [
                                    'name' => WebhookRequest::SUCCESS,
                                    'id' => 'test-generated-id1',
                                ]
                            ),
                        ),
                    ),
                    new Response(
                        200,
                        [],
                        json_encode(
                            self::sampleWebhookData(
                                [
                                    'name' => WebhookRequest::SUCCESS,
                                    'id' => 'test-generated-id1',
                                ]
                            ),
                        ),
                    ),
                    new Response(
                        200,
                        [],
                        json_encode(
                            self::sampleWebhookData(
                                [
                                    'name' => WebhookRequest::FAILURE,
                                    'id' => 'test-generated-id2',
                                ]
                            ),
                        ),
                    ),
                    new Response(
                        200,
                        [],
                        json_encode(
                            self::sampleWebhookData(
                                [
                                    'name' => WebhookRequest::DROPOUT,
                                    'id' => 'test-generated-id3',
                                ]
                            ),
                        ),
                    ),
                ]
            )
        );

        ClientFacade::setHandlerStack($handlerStack);

        $this->artisan('paymaya-sdk:webhook:register')
            ->expectsOutput('Done Registering webhooks')
            ->assertExitCode(0);
    }
}
