<?php

namespace Lloricode\LaravelPaymaya\Commands\Customization;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;

class DeleteCustomizationCommand extends Command
{
    public $signature = 'paymaya-sdk:customization:delete';

    public $description = 'Delete registered customization';

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     */
    public function handle(): void
    {
        PaymayaFacade::customization()->delete();

        $this->info('Done deleting customization');
    }
}
