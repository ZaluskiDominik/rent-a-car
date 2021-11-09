<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Exception;

use RuntimeException;

final class TenantNotFound extends RuntimeException
{
    public function __construct(string $tenantId)
    {
        parent::__construct("Tenant with ID '{$tenantId}' does not exist");
    }
}
