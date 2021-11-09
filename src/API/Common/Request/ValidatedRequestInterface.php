<?php

declare(strict_types=1);

namespace App\API\Common\Request;

use Symfony\Component\HttpFoundation\Request;

interface ValidatedRequestInterface
{
    public static function getInput(Request $request): array;
}
