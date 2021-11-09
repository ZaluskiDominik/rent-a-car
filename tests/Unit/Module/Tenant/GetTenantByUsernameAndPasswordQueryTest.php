<?php

declare(strict_types=1);

namespace Tests\Unit\Module\Tenant;

use App\Module\Tenant\API\TenantAPI;
use App\Module\Tenant\Domain\Entity\Tenant;
use App\Module\Tenant\Domain\Repository\TenantRepositoryInterface;
use App\Module\Tenant\Domain\Service\PasswordHasher;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class GetTenantByUsernameAndPasswordQueryTest extends KernelTestCase
{
    private TenantRepositoryInterface $repository;
    private PasswordHasher $passwordHasher;

    private TenantAPI $tenantAPI;

    public function setUp(): void
    {
        self::bootKernel();

        $this->repository = self::getContainer()->get(TenantRepositoryInterface::class);
        $this->passwordHasher = self::getContainer()->get(PasswordHasher::class);
        $this->tenantAPI = self::getContainer()->get(TenantAPI::class);
    }

    public function test_TenantDoesNotExists_NullReturned(): void
    {
        $tenant = $this->tenantAPI->getByUsernameAndPassword('username', 'password123');

        $this->assertNull($tenant);
    }

    public function test_TenantWithUsernameExistsButDifferentPassword_NullReturned(): void
    {
        $this->repository->save($this->prepareTenant());

        $tenant = $this->tenantAPI->getByUsernameAndPassword('super_user', 'password123');

        $this->assertNull($tenant);
    }

    public function test_TenantWithUsernameExistsAndCorrectPassword_ReturnsTenant(): void
    {
        $this->repository->save($this->prepareTenant());

        $tenant = $this->tenantAPI->getByUsernameAndPassword('super_user', 'super_passoword123');

        $this->assertInstanceOf(Tenant::class, $tenant);
    }

    private function prepareTenant(): Tenant
    {
        return new Tenant(
            'uuid',
            'email@example.pl',
            'name',
            'surname',
            '98-009',
            'Warsaw',
            'PL',
            'super_user',
            $this->passwordHasher->hash('super_passoword123'),
            22
        );
    }
}
