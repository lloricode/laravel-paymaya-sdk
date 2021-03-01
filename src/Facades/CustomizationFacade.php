<?php

namespace Lloricode\LaravelPaymaya\Facades;

use Illuminate\Support\Facades\Facade;
use Lloricode\Paymaya\Client\Checkout\CustomizationClient;

/**
 * @mixin \Lloricode\Paymaya\Client\Checkout\CustomizationClient
 */
class CustomizationFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CustomizationClient::class;
    }
}
