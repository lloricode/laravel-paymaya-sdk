<?php

namespace Lloricode\LaravelPaymaya\Facades;

use Illuminate\Support\Facades\Facade;
use Lloricode\Paymaya\PaymayaClient;

/**
 * @mixin \Lloricode\Paymaya\PaymayaClient
 */
class ClientFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PaymayaClient::class;
    }
}
