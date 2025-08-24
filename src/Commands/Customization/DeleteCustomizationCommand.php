<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Commands\Customization;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\Requests\Customization\DeleteCustomizationRequest;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'paymaya-sdk:customization:delete', description: 'Delete registered customization')]
class DeleteCustomizationCommand extends Command
{
    public function handle(): int
    {
        PaymayaFacade::connector()->send(new DeleteCustomizationRequest);

        $this->info('Done deleting customization');

        return self::SUCCESS;
    }
}
