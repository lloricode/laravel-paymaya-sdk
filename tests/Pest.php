<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Lloricode\LaravelPaymaya\Tests\TestCase;

uses(TestCase::class)
    ->beforeEach(function () {
        if (version_compare(app()->version(), '9.0.0', '>=')) {
            Http::preventStrayRequests();
        }
        config([
            'paymaya-sdk.keys' => [
                'public' => 'public-xxx',
                'secret' => 'secret-xxx',
            ],
        ]);
    })
    ->in(__DIR__);
