<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya;

use Lloricode\Paymaya\PaymayaConnector;

class LaravelPaymaya
{
    public static function connector(): PaymayaConnector
    {
        return app(PaymayaConnector::class);
    }
}
