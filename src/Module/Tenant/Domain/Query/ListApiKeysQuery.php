<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Query;

use App\Module\Tenant\Domain\Entity\ApiKey;
use App\Module\Tenant\Domain\Exception\TenantNotFound;
use App\Module\Tenant\Domain\Repository\TenantRepositoryInterface;

final class ListApiKeysQuery
{
    private TenantRepositoryInterface $tenantRepository;

    public function __construct(TenantRepositoryInterface $tenantRepository)
    {
        $this->tenantRepository = $tenantRepository;
    }

    /** @return array<ApiKey> */
    public function execute(string $tenantId): array
    {
        $tenant = $this->tenantRepository->findById($tenantId);
        if (!$tenant) {
            throw new TenantNotFound($tenantId);
        }

        return $tenant->getApiKeys()->getValues();
    }
}
