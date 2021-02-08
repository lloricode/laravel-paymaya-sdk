<?php

namespace Lloricode\LaravelPaymaya\Facades;

use Illuminate\Support\Facades\Facade;
use Lloricode\Paymaya\Client\Checkout\CheckoutClient;

/**
 * @mixin \Lloricode\Paymaya\Client\Checkout\CheckoutClient
 */
class CheckoutFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CheckoutClient::class;
    }
}
