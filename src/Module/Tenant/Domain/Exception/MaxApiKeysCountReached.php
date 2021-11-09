<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Exception;

use RuntimeException;

final class MaxApiKeysCountReached extends RuntimeException
{
    public function __construct(int $maxApiKeysCount)
    {
        parent::__construct("Max number of API keys ({$maxApiKeysCount} keys) already reached");
    }
}
