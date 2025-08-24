<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Commands\Webhook\Checkout;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\DataTransferObjects\Webhook\WebhookDto;
use Lloricode\Paymaya\Requests\Webhook\RetrieveWebhookRequest;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'paymaya-sdk:webhook:retrieve', description: 'Retrieve registered webhooks')]
class RetrieveWebhookCommand extends Command
{
    public function handle(): void
    {
        $this->table(['id', 'name', 'callbackUrl', 'createdAt', 'updatedAt'], $this->retrieveWebhooks());
    }

    public function retrieveWebhooks(): array
    {
        $return = [];

        /** @var array<string, WebhookDto> $webhookDtos */
        $webhookDtos = PaymayaFacade::connector()->send(new RetrieveWebhookRequest)->dto();

        foreach ($webhookDtos as $webhookDto) {
            /** @var WebhookDto $webhookDto */
            $return[] = [
                'id' => $webhookDto->id,
                'name' => $webhookDto->name,
                'callbackUrl' => $webhookDto->callbackUrl,
                'createdAt' => $webhookDto->createdAt,
                'updatedAt' => $webhookDto->updatedAt,
            ];
        }

        return $return;
    }
}
