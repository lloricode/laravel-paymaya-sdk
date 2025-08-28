<?php

declare(strict_types=1);

use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\Requests\Checkout\CreateCheckoutRequest;
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
            CreateCheckoutRequest::class => new MockResponse(
                body: [
                    'checkoutId' => $id,
                    'redirectUrl' => $url,
                ]
            ),
        ]);

        $checkoutResponse = PaymayaFacade::createCheckout(TestHelper::buildCheckout());

        assertSame($id, $checkoutResponse->checkoutId);
        assertSame($url, $checkoutResponse->redirectUrl);
    }
);
