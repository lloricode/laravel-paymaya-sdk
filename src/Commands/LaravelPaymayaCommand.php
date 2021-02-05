<?php

namespace Lloricode\LaravelPaymaya\Commands;

use Illuminate\Console\Command;

class LaravelPaymayaCommand extends Command
{
    public $signature = 'laravel-paymaya-sdk';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
