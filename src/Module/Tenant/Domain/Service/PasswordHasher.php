<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Service;

use RuntimeException;

final class PasswordHasher
{
    public function hash(string $password): string
    {
        $hash = password_hash($password,  PASSWORD_DEFAULT);
        if (!$hash) {
            throw new RuntimeException("Could not hash a password");
        }

        return $hash;
    }

    public function verify(string $password, string $passwordHash): bool
    {
        return password_verify($password, $passwordHash);
    }
}
