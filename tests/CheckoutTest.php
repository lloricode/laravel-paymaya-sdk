<?php

namespace Lloricode\LaravelPaymaya\Tests;

use ErrorException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Lloricode\LaravelPaymaya\Facades\CheckoutFacade;
use Lloricode\LaravelPaymaya\Facades\ClientFacade;
use Lloricode\Paymaya\Test\TestHelper;

class CheckoutTest extends TestCase
{
    /**
     * @test
     */
    public function success()
    {
        $id = 'test-generated-id';
        $url = 'http://test';

        $mock = new MockHandler(
            [
                new Response(
                    200,
                    [],
                    json_encode(
                        [
                            'checkoutId' => $id,
                            'redirectUrl' => 'http://test',
                        ]
                    ),
                ),
            ]
        );

        $handlerStack = HandlerStack::create(
            $mock
        );

        ClientFacade::setHandlerStack($handlerStack);

        try {
            $checkoutResponse = CheckoutFacade::execute(TestHelper::buildCheckout());
        } catch (ErrorException $e) {
            $this->fail('ErrorException');
        } catch (ClientException $e) {
            $this->fail('ClientException: '.$e->getMessage().$e->getResponse()->getBody());
        } catch (GuzzleException $e) {
            $this->fail('GuzzleException');
        }

        $this->assertEquals($id, $checkoutResponse->getId());
        $this->assertEquals($url, $checkoutResponse->getUrl());
    }
}
