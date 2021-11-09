<?php

declare(strict_types=1);

namespace App\Module\Tenant\API;

use App\Module\Tenant\Domain\Entity\ApiKey;
use App\Module\Tenant\Domain\Query\ListApiKeysQuery;
use App\Module\Tenant\Domain\Service\CreateApiKeyService;
use App\Module\Tenant\Domain\Service\DeleteApiKeyService;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

final class ApiKeyAPI implements ServiceSubscriberInterface
{
    private ContainerInterface $serviceLocator;

    public function __construct(ContainerInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function create(string $tenantId): ApiKey
    {
        return $this->serviceLocator->get(CreateApiKeyService::class)->execute($tenantId);
    }

    public function list(string $tenantId): array
    {
        return $this->serviceLocator->get(ListApiKeysQuery::class)->execute($tenantId);
    }

    public function delete(string $apiKey): void
    {
        $this->serviceLocator->get(DeleteApiKeyService::class)->execute($apiKey);
    }

    public function validate(string $apiKey): bool
    {
        return true;
    }

    public static function getSubscribedServices(): array
    {
        return [
            CreateApiKeyService::class,
            ListApiKeysQuery::class,
            DeleteApiKeyService::class,
        ];
    }


}
