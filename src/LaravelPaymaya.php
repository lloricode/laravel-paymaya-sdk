<?php

namespace Lloricode\LaravelPaymaya;

use Lloricode\LaravelPaymaya\Facades\CheckoutFacade;
use Lloricode\LaravelPaymaya\Facades\ClientFacade;
use Lloricode\Paymaya\Client\Checkout\CheckoutClient;
use Lloricode\Paymaya\PaymayaClient;

class LaravelPaymaya
{
    public static function client(): PaymayaClient
    {
        return ClientFacade::getFacadeRoot();
    }

    public static function checkout(): CheckoutClient
    {
        return CheckoutFacade::getFacadeRoot();
    }
}
