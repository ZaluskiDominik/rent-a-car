<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Query;

use App\Module\Tenant\Domain\Entity\Tenant;
use App\Module\Tenant\Domain\Repository\TenantRepositoryInterface;
use App\Module\Tenant\Domain\Service\PasswordHasher;

final class GetTenantByUsernameAndPasswordQuery
{
    private TenantRepositoryInterface $tenantRepository;
    private PasswordHasher $passwordHasher;

    public function __construct(TenantRepositoryInterface $tenantRepository, PasswordHasher $passwordHasher)
    {
        $this->tenantRepository = $tenantRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function execute(string $username, string $password): ?Tenant
    {
        $tenant = $this->tenantRepository->findByUsername($username);
        if (!$tenant) {
            return null;
        }
        if (!$this->passwordHasher->verify($password, $tenant->getPasswordHash())) {
            return null;
        }

        return $tenant;
    }
}
