<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Commands\Customization;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'paymaya-sdk:customization:remove', description: 'Remove customization')]
class RemoveCustomizationCommand extends Command
{
    public function handle(): int
    {
        PaymayaFacade::deleteCustomization();

        $this->info('Done deleting customization');

        return self::SUCCESS;
    }
}
