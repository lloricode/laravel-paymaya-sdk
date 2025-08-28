<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Commands\Webhook;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\DataTransferObjects\Webhook\WebhookDto;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'paymaya-sdk:webhook:all', description: 'Get all webhooks')]
class GetAllWebhookCommand extends Command
{
    public function handle(): int
    {

        try {
            $webhookDtos = PaymayaFacade::webhooks();
        } catch (\Saloon\Exceptions\Request\RequestException $e) {
            if ($e->getStatus() === 404) {
                $webhookDtos = [];
            } else {
                throw $e;
            }
        }

        $webhooks = [];

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
