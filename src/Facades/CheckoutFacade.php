<?php

namespace Lloricode\LaravelPaymaya\Facades;

use Illuminate\Support\Facades\Facade;
use Lloricode\LaravelPaymaya\CheckoutClient;

/**
 * @mixin CheckoutClient
 */
class CheckoutFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CheckoutClient::class;
    }
}
