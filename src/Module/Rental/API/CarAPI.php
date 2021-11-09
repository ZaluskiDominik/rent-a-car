<?php

declare(strict_types=1);

namespace App\Module\Car\API;

use App\Module\Car\Domain\Request\ListCarsRequest;

final class CarAPI
{
    public function listCars(ListCarsRequest $request): array
    {
        return [];
    }
}
