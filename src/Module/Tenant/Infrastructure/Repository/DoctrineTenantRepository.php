<?php

declare(strict_types=1);

namespace App\Module\Tenant\Infrastructure\Repository;

use App\Module\Tenant\Domain\Entity\Tenant;
use App\Module\Tenant\Domain\Repository\TenantRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\Uuid;

/** @extends ServiceEntityRepository<Tenant> */
final class DoctrineTenantRepository extends ServiceEntityRepository implements TenantRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tenant::class);
    }

    public function generateId(): string
    {
        return (string)Uuid::uuid4();
    }

    public function save(Tenant $tenant): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($tenant);
        $entityManager->flush();
    }

    public function findById(string $id): ?Tenant
    {
        return $this->find($id);
    }

    public function findByEmail(string $email): ?Tenant
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function findByUsername(string $username): ?Tenant
    {
        return $this->findOneBy(['username' => $username]);
    }
}
