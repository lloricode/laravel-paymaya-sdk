<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Tests;

use Lloricode\LaravelPaymaya\LaravelPaymayaServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelPaymayaServiceProvider::class,
        ];
    }
}
