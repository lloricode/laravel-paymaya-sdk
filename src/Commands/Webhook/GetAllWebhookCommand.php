<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Commands\Webhook;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\DataTransferObjects\Webhook\WebhookDto;
use Lloricode\Paymaya\Requests\Webhook\GetAllWebhookRequest;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'paymaya-sdk:webhook:retrieve', description: 'Retrieve registered webhooks')]
class GetAllWebhookCommand extends Command
{
    public function handle(): int
    {

        $webhooks = [];

        $response = PaymayaFacade::connector()->send(new GetAllWebhookRequest);

        if ($response->status() === 404) {
            // no webhooks found, return empty table
        } elseif ($response->failed()) {
            $response->throw();

            return self::FAILURE;
        }

        /** @var array<string, WebhookDto> $webhookDtos */
        $webhookDtos = $response->status() === 404 ? [] : $response->dto();

        foreach ($webhookDtos as $webhookDto) {
            /** @var WebhookDto $webhookDto */
            $webhooks[] = [
                'id' => $webhookDto->id,
                'name' => $webhookDto->name,
                'callbackUrl' => $webhookDto->callbackUrl,
                'createdAt' => $webhookDto->createdAt,
                'updatedAt' => $webhookDto->updatedAt,
            ];
        }

        $this->table(['id', 'name', 'callbackUrl', 'createdAt', 'updatedAt'], $webhooks);

        return self::SUCCESS;
    }
}
