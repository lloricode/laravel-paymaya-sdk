<?php

namespace Lloricode\LaravelPaymaya;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Lloricode\LaravelPaymaya\LaravelPaymaya
 */
class LaravelPaymayaFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-paymaya-sdk';
    }
}
