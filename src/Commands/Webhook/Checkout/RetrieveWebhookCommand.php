<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Commands\Webhook\Checkout;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;

class RetrieveWebhookCommand extends Command
{
    public $signature = 'paymaya-sdk:webhook:retrieve';

    public $description = 'Retrieve registered webhooks';

    /** @throws \GuzzleHttp\Exception\GuzzleException*/
    public function handle(): void
    {
        $this->table(['id', 'name', 'callbackUrl', 'createdAt', 'updatedAt'], $this->retrieveWebhooks());
    }

    /** @throws \GuzzleHttp\Exception\GuzzleException*/
    public function retrieveWebhooks(): array
    {
        $return = [];

        foreach (PaymayaFacade::webhook()->retrieve() as $webhookResponse) {
            $return[] = [
                'id' => $webhookResponse->id,
                'name' => $webhookResponse->name,
                'callbackUrl' => $webhookResponse->callbackUrl,
                'createdAt' => $webhookResponse->createdAt,
                'updatedAt' => $webhookResponse->updatedAt,
            ];
        }

        return $return;
    }
}
