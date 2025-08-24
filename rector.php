<?php

declare(strict_types=1);

return Rector\Config\RectorConfig::configure()
    ->withPhpSets()
    ->withPaths([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withCache(
        cacheDirectory: 'build/rector',
        cacheClass: Rector\Caching\ValueObject\Storage\FileCacheStorage::class,
    );
