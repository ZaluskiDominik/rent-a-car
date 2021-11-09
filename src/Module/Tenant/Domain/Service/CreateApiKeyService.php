<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Service;

use App\Module\Tenant\Domain\Entity\ApiKey;
use App\Module\Tenant\Domain\Exception\MaxApiKeysCountReached;
use App\Module\Tenant\Domain\Exception\TenantNotFound;
use App\Module\Tenant\Domain\Repository\ApiKeyRepositoryInterface;
use App\Module\Tenant\Domain\Repository\TenantRepositoryInterface;

final class CreateApiKeyService
{
    private const MAX_API_KEYS_COUNT = 10;

    private TenantRepositoryInterface $tenantRepository;
    private ApiKeyRepositoryInterface $apiKeyRepository;
    private ApiKeyGenerator $apiKeyGenerator;

    public function __construct(
        TenantRepositoryInterface $tenantRepository,
        ApiKeyRepositoryInterface $apiKeyRepository,
        ApiKeyGenerator $apiKeyGenerator
    ) {
        $this->tenantRepository = $tenantRepository;
        $this->apiKeyRepository = $apiKeyRepository;
        $this->apiKeyGenerator = $apiKeyGenerator;
    }

    public function execute(string $tenantId): ApiKey
    {
        $tenant = $this->tenantRepository->findById($tenantId);
        if (!$tenant) {
            throw new TenantNotFound($tenantId);
        }

        if (count($tenant->getApiKeys()) >= self::MAX_API_KEYS_COUNT) {
            throw new MaxApiKeysCountReached(self::MAX_API_KEYS_COUNT);
        }

        $apiKey = new ApiKey($this->apiKeyGenerator->generate(), $tenant);
        $this->apiKeyRepository->save($apiKey);

        return $apiKey;
    }
}
