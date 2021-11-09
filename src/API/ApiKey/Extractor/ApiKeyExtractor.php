<?php

declare(strict_types=1);

namespace App\API\ApiKey\Extractor;

use App\Module\Tenant\Domain\Entity\ApiKey;

final class ApiKeyExtractor
{
    /**
     * @param array<int, ApiKey> $apiKeyList
     * @return array<array<string, string|int>>
     */
    public function extractList(array $apiKeyList): array
    {
        return array_map([$this, 'extract'], $apiKeyList);
    }

    /** @return array<string, string|int> */
    public function extract(ApiKey $apiKey): array
    {
        return [
            'apiKey' => $apiKey->getApiKey(),
            'tenantId' => $apiKey->getTenant()->getId(),
            'createdAt' => $apiKey->getCreatedAt(),
        ];
    }
}
