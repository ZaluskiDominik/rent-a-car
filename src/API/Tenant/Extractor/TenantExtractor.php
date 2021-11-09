<?php

declare(strict_types=1);

namespace App\API\Tenant\Extractor;

use App\Module\Tenant\Domain\Entity\Tenant;

final class TenantExtractor
{
    /** @return array<string, string|int> */
    public function extract(Tenant $tenant): array
    {
        return array_filter([
            'id' => $tenant->getId(),
            'email' => $tenant->getEmail(),
            'name' => $tenant->getName(),
            'surname' => $tenant->getSurname(),
            'zipCode' => $tenant->getZipCode(),
            'city' => $tenant->getCity(),
            'country' => $tenant->getCountry(),
            'username' => $tenant->getUsername(),
            'age' => $tenant->getAge(),
        ], fn($x) => isset($x));
    }
}
