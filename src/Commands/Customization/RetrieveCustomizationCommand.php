<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Commands\Customization;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\Requests\Customization\RetrieveCustomizationRequest;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'paymaya-sdk:customization:retrieve', description: 'Retrieve registered customization')]
class RetrieveCustomizationCommand extends Command
{
    public function handle(): int
    {
        $response = PaymayaFacade::connector()->send(new RetrieveCustomizationRequest);

        if ($response->status() === 404) {
            //
        } elseif ($response->failed()) {
            report($response->toException());

            $this->error('Failed retrieve customization: '.$response->array('error', 'unknown'));

            return self::FAILURE;
        }

        $arrayData = $response->status() === 404 ? [] : $response->array();

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

            $value = $arrayData[$field] ?? null;

            $rows[] = [$field, is_bool($value) ? ($value ? 'true' : 'false') : $value];
        }

        $this->table(['Field', 'Value'], $rows);

        return self::SUCCESS;
    }
}
