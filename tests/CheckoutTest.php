<?php

declare(strict_types=1);

use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\Requests\Checkout\SubmitCheckoutRequest;
use Lloricode\Paymaya\Response\Checkout\CheckoutResponse;
use Lloricode\Paymaya\Test\TestHelper;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

use function PHPUnit\Framework\assertSame;

it(
    'success checkout',
    function () {
        $id = 'test-generated-id';
        $url = 'http://test';

        MockClient::global([
            SubmitCheckoutRequest::class => new MockResponse(
                body: [
                    'checkoutId' => $id,
                    'redirectUrl' => $url,
                ]
            ),
        ]);

        /** @var CheckoutResponse $checkoutResponse */
        $checkoutResponse = PaymayaFacade::connector()->send(new SubmitCheckoutRequest(TestHelper::buildCheckout()))->dto();

        assertSame($id, $checkoutResponse->checkoutId);
        assertSame($url, $checkoutResponse->redirectUrl);
    }
);
