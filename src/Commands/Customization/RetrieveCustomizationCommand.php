<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Commands\Customization;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'paymaya-sdk:customization:retrieve', description: 'Retrieve customization')]
class RetrieveCustomizationCommand extends Command
{
    public function handle(): int
    {
        try {
            $arrayData = PaymayaFacade::customizations();
        } catch (\Saloon\Exceptions\Request\RequestException $e) {
            if ($e->getStatus() === 404) {
                $arrayData = [];
            } else {
                throw $e;
            }
        }

        $rows = [];

        foreach ([
            'logoUrl',
            'iconUrl',
            'appleTouchIconUrl',
            'customTitle',
            'colorScheme',
            'redirectTimer',
            'hideReceiptInput',
            'skipResultPage',
            'showMerchantName',
        ] as $field) {

            $value = $arrayData->$field ?? null;

            $rows[] = [$field, is_bool($value) ? ($value ? 'true' : 'false') : $value];
        }

        $this->table(['Field', 'Value'], $rows);

        return self::SUCCESS;
    }
}
