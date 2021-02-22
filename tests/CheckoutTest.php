<?php

namespace Lloricode\LaravelPaymaya\Tests;

use ErrorException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
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
                            'redirectUrl' => $url,
                        ]
                    ),
                ),
            ]
        );

        $handlerStack = HandlerStack::create(
            $mock
        );

        PaymayaFacade::client()->setHandlerStack($handlerStack);

        try {
            $checkoutResponse = PaymayaFacade::checkout()->execute(TestHelper::buildCheckout());
//            $checkoutResponse = CheckoutFacade::execute(TestHelper::buildCheckout());
        } catch (ErrorException $e) {
            $this->fail('ErrorException');
        } catch (ClientException $e) {
            $this->fail('ClientException: '.$e->getMessage().$e->getResponse()->getBody());
        } catch (GuzzleException $e) {
            $this->fail('GuzzleException');
        }

        $this->assertEquals($id, $checkoutResponse->checkoutId);
        $this->assertEquals($url, $checkoutResponse->redirectUrl);
    }
}
