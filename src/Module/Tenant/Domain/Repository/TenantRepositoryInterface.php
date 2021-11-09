<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Repository;

use App\Module\Tenant\Domain\Entity\Tenant;

interface TenantRepositoryInterface
{
    public function generateId(): string;
    public function save(Tenant $tenant): void;
    public function findById(string $id): ?Tenant;
    public function findByEmail(string $email): ?Tenant;
    public function findByUsername(string $username): ?Tenant;
}
