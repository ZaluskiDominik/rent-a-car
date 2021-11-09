<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Exception;

use RuntimeException;

final class EmailAlreadyExists extends RuntimeException
{
    public function __construct(string $email)
    {
        parent::__construct("Email '{$email}' already exists");
    }
}
