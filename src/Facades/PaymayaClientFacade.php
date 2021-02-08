<?php

namespace Lloricode\LaravelPaymaya\Facades;

use Illuminate\Support\Facades\Facade;
use Lloricode\Paymaya\PaymayaClient;

/**
 * @mixin PaymayaClient
 */
class PaymayaClientFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PaymayaClient::class;
    }
}
