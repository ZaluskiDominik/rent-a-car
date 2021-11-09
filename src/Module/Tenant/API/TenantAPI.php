<?php

declare(strict_types=1);

namespace App\Module\Tenant\API;

use App\Module\Tenant\Domain\Entity\Tenant;
use App\Module\Tenant\Domain\Query\GetTenantByUsernameAndPasswordQuery;
use App\Module\Tenant\Domain\Request\CreateTenantRequest;
use App\Module\Tenant\Domain\Service\CreateTenantService;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

final class TenantAPI implements ServiceSubscriberInterface
{
    private ContainerInterface $serviceLocator;

    public function __construct(ContainerInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public static function getSubscribedServices(): array
    {
        return [
            CreateTenantService::class,
            GetTenantByUsernameAndPasswordQuery::class,
        ];
    }

    public function create(CreateTenantRequest $request): Tenant
    {
        return $this->serviceLocator->get(CreateTenantService::class)->execute($request);
    }

    public function getByUsernameAndPassword(string $username, string $password): ?Tenant
    {
        return $this->serviceLocator->get(GetTenantByUsernameAndPasswordQuery::class)->execute($username, $password);
    }
}
