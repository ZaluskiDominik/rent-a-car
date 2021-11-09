<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Repository;

use App\Module\Tenant\Domain\Entity\ApiKey;

interface ApiKeyRepositoryInterface
{
    public function save(ApiKey $apiKey): void;
    public function findById(string $apiKey): ?ApiKey;
    public function delete(ApiKey $apiKey): void;
}
