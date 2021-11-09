<?php

declare(strict_types=1);

namespace App\Module\Tenant\Infrastructure\Repository;

use App\Module\Tenant\Domain\Entity\ApiKey;
use App\Module\Tenant\Domain\Repository\ApiKeyRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ApiKey>
 */
final class DoctrineApiKeyRepository extends ServiceEntityRepository implements ApiKeyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiKey::class);
    }

    public function save(ApiKey $apiKey): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($apiKey);
        $entityManager->flush();
    }

    public function findById(string $apiKey): ?ApiKey
    {
        return $this->find($apiKey);
    }

    public function delete(ApiKey $apiKey): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($apiKey);
        $entityManager->flush();
    }
}
