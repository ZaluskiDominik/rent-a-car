<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Service;

final class ApiKeyGenerator
{
    public function generate(): string
    {
        return bin2hex(random_bytes(32));
    }
}
