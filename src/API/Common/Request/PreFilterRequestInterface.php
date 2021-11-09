<?php

declare(strict_types=1);

namespace App\API\Common\Request;

interface PreFilterRequestInterface
{
    public function preFilter(): void;
}
