<?php

namespace Lloricode\LaravelPaymaya\Tests;

use Lloricode\LaravelPaymaya\LaravelPaymayaServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelPaymayaServiceProvider::class,
        ];
    }
}
