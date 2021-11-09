<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Exception;

use RuntimeException;

final class UsernameAlreadyExists extends RuntimeException
{
    public function __construct(string $username)
    {
        parent::__construct("Username '{$username}' already exists");
    }
}
