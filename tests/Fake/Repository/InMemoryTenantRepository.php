<?php

declare(strict_types=1);

namespace Tests\Fake\Repository;

use App\Module\Tenant\Domain\Entity\Tenant;
use App\Module\Tenant\Domain\Repository\TenantRepositoryInterface;
use Ramsey\Uuid\Uuid;

final class InMemoryTenantRepository implements TenantRepositoryInterface
{
    /** @var array<int, Tenant> */
    private array $persistedData = [];

    public function generateId(): string
    {
        return (string)Uuid::uuid4();
    }

    public function save(Tenant $tenant): void
    {
        $this->persistedData[] = $tenant;
    }

    public function findById(string $id): ?Tenant
    {
        return array_filter($this->persistedData, fn(Tenant $tenant) => $tenant->getId() === $id)[0] ?? null;
    }

    public function findByEmail(string $email): ?Tenant
    {
        return array_filter($this->persistedData, fn(Tenant $tenant) => $tenant->getEmail() === $email)[0] ?? null;
    }

    public function findByUsername(string $username): ?Tenant
    {
        return array_filter($this->persistedData, fn(Tenant $tenant) => $tenant->getUsername() === $username)[0] ?? null;
    }
}
