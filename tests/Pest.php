<?php

declare(strict_types=1);

use Lloricode\LaravelPaymaya\Tests\TestCase;

uses(TestCase::class)
    ->beforeEach(fn () => config(
        [
            'paymaya-sdk.keys' => [
                'public' => 'public-xxx',
                'secret' => 'secret-xxx',
            ],
        ]
    ))
    ->in(__DIR__);
