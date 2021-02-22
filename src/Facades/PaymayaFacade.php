<?php

namespace Lloricode\LaravelPaymaya\Facades;

use Illuminate\Support\Facades\Facade;
use Lloricode\LaravelPaymaya\LaravelPaymaya;

/**
 * @mixin \Lloricode\LaravelPaymaya\LaravelPaymaya
 */
class PaymayaFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return LaravelPaymaya::class;
    }
}
