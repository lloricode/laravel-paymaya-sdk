<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Commands\Customization;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\Requests\Customization\RemoveCustomizationRequest;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'paymaya-sdk:customization:remove', description: 'Remove customization')]
class RemoveCustomizationCommand extends Command
{
    public function handle(): int
    {
        $response = PaymayaFacade::connector()->send(new RemoveCustomizationRequest);

        if ($response->successful()) {
            $this->info('Done deleting customization');

            return self::SUCCESS;
        }

        $response->throw();

        // @codeCoverageIgnoreStart
        return self::FAILURE;
        // @codeCoverageIgnoreEnd
    }
}
