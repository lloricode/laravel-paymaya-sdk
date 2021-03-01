<?php

namespace Lloricode\LaravelPaymaya\Commands\Customization;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;

class RetrieveCustomizationCommand extends Command
{
    public $signature = 'paymaya-sdk:customization:retrieve';

    public $description = 'Retrieve registered customization';

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     */
    public function handle(): void
    {
        $data = PaymayaFacade::customization()->retrieve()->toArray();

        $rows = [];

        foreach ($data as $field => $value) {
            $rows[] = [$field, is_bool($value) ? ($value ? 'true' : 'false') : $value];
        }

        $this->table(['Field', 'Value'], $rows);
    }
}
