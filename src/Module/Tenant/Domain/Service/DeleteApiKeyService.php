<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Service;

use App\Module\Tenant\Domain\Exception\ApiKeyNotFound;
use App\Module\Tenant\Domain\Repository\ApiKeyRepositoryInterface;

final class DeleteApiKeyService
{
    private ApiKeyRepositoryInterface $apiKeyRepository;

    public function __construct(ApiKeyRepositoryInterface $apiKeyRepository)
    {
        $this->apiKeyRepository = $apiKeyRepository;
    }

    public function execute(string $apiKey): void
    {
        $apiKeyEntity = $this->apiKeyRepository->findById($apiKey);
        if (!$apiKeyEntity) {
            throw new ApiKeyNotFound($apiKey);
        }

        $this->apiKeyRepository->delete($apiKeyEntity);
    }
}
