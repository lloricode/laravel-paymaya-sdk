<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Facades;

use Illuminate\Support\Facades\Facade;
use Lloricode\Paymaya\Paymaya;

/**
 * @mixin \Lloricode\Paymaya\Paymaya
 */
class PaymayaFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Paymaya::class;
    }
}
