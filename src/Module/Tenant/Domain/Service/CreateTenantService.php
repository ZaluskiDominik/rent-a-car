<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Service;

use App\Module\Tenant\Domain\Entity\Tenant;
use App\Module\Tenant\Domain\Exception\EmailAlreadyExists;
use App\Module\Tenant\Domain\Exception\UsernameAlreadyExists;
use App\Module\Tenant\Domain\Repository\TenantRepositoryInterface;
use App\Module\Tenant\Domain\Request\CreateTenantRequest;

final class CreateTenantService
{
    private TenantRepositoryInterface $tenantRepository;
    private PasswordHasher $passwordHasher;

    public function __construct(TenantRepositoryInterface $tenantRepository, PasswordHasher $passwordHasher)
    {
        $this->tenantRepository = $tenantRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function execute(CreateTenantRequest $request): Tenant
    {
        if ($this->tenantRepository->findByEmail($request->getEmail())) {
            throw new EmailAlreadyExists($request->getEmail());
        }
        if ($this->tenantRepository->findByUsername($request->getUsername())) {
            throw new UsernameAlreadyExists($request->getUsername());
        }

        $tenant = new Tenant(
            $this->tenantRepository->generateId(),
            $request->getEmail(),
            $request->getName(),
            $request->getSurname(),
            $request->getZipCode(),
            $request->getCity(),
            $request->getCountry(),
            $request->getUsername(),
            $this->passwordHasher->hash($request->getPassword()),
            $request->getAge()
        );

        $this->tenantRepository->save($tenant);

        return $tenant;
    }
}
