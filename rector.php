<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\ValueObject\PhpVersion;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__.'/src',
        __DIR__.'/tests',
    ]);

    $rectorConfig->sets([
        SetList::PHP_82,
    ]);

    $rectorConfig->phpVersion(PhpVersion::PHP_82);

    //    $rectorConfig->phpstanConfig(__DIR__ . '/phpstan.neon.dist');
};
