<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Exception;

use RuntimeException;

final class ApiKeyNotFound extends RuntimeException
{
    public function __construct(string $apiKey)
    {
        parent::__construct("API key '{$apiKey}' does not exist");
    }
}
