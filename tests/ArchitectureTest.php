<?php

declare(strict_types=1);

test('Not debugging statements are left in our code.')
    ->expect(['dd', 'dump', 'ray', 'rd', 'die', 'eval', 'sleep', 'debug', 'var_dump', 'env'])
    ->not->toBeUsed();
