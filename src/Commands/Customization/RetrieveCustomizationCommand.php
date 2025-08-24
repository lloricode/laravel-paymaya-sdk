<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Commands\Customization;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\DataTransferObjects\Checkout\Customization\CustomizationDto;
use Lloricode\Paymaya\Requests\Customization\RetrieveCustomizationRequest;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'paymaya-sdk:customization:retrieve', description: 'Retrieve registered customization')]
class RetrieveCustomizationCommand extends Command
{
    public function handle(): int
    {
        /** @var CustomizationDto $data */
        $data = PaymayaFacade::connector()->send(new RetrieveCustomizationRequest)->dto();

        $rows = [];

        foreach ((array) $data as $field => $value) {
            $rows[] = [$field, is_bool($value) ? ($value ? 'true' : 'false') : $value];
        }

        $this->table(['Field', 'Value'], $rows);

        return self::SUCCESS;
    }
}
