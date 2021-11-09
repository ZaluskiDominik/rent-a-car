<?php

declare(strict_types=1);

namespace Tests\Unit\Module\Tenant;

use App\Module\Tenant\API\TenantAPI;
use App\Module\Tenant\Domain\Entity\Tenant;
use App\Module\Tenant\Domain\Exception\EmailAlreadyExists;
use App\Module\Tenant\Domain\Exception\UsernameAlreadyExists;
use App\Module\Tenant\Domain\Request\CreateTenantRequest;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CreateTenantServiceTest extends KernelTestCase
{
    private TenantAPI $tenantAPI;

    public function setUp(): void
    {
        self::bootKernel();

        $this->tenantAPI = self::getContainer()->get(TenantAPI::class);
    }

    public function test_ExistingEmailPassed_Failure(): void
    {
        $request = $this->prepareRequest();
        $this->tenantAPI->create($request);

        $this->expectException(EmailAlreadyExists::class);
        $requestWithSameEmail = new CreateTenantRequest(
            'email@domain.com',
            'Joe',
            'Doe',
            '77-209',
            'Praga',
            'CZ',
            'abcde12345',
            'qwerty123456',
            23
        );
        $this->tenantAPI->create($requestWithSameEmail);
    }

    public function test_ExistingUsernamePassed_Failure(): void
    {
        $request = $this->prepareRequest();
        $this->tenantAPI->create($request);

        $this->expectException(UsernameAlreadyExists::class);
        $requestWithSameUsername = new CreateTenantRequest(
            'email2@domain.com',
            'Joe',
            'Doe',
            '77-209',
            'Praga',
            'CZ',
            'simpler-user',
            'qwerty123456',
            23
        );
        $this->tenantAPI->create($requestWithSameUsername);
    }

    public function test_NewTenant_TenantCreated(): void
    {
        $request = $this->prepareRequest();

        $response = $this->tenantAPI->create($request);

        $this->assertTenantCreated($request, $response);
    }

    public function test_TwoTenantsWithDifferentData_TenantsCreated(): void
    {
        $request1 = $this->prepareRequest();
        $request2 = $this->prepareRequest('email2@domain.com', 'other-username');

        $response1 = $this->tenantAPI->create($request1);
        $response2 = $this->tenantAPI->create($request2);

        $this->assertTenantCreated($request1, $response1);
        $this->assertTenantCreated($request2, $response2);
    }

    private function prepareRequest(string $email = 'email@domain.com', string $username = 'simpler-user'): CreateTenantRequest
    {
        return new CreateTenantRequest(
            $email,
            'Smith',
            'John',
            '84-298',
            'Warsaw',
            'PL',
            $username,
            'hard-to-guess-password'
        );
    }

    private function assertTenantCreated(CreateTenantRequest $request, Tenant $createdTenant): void
    {
        $this->assertEquals(36, strlen($createdTenant->getId()));
        $this->assertEquals($request->getEmail(), $createdTenant->getEmail());
        $this->assertEquals($request->getName(), $createdTenant->getName());
        $this->assertEquals($request->getSurname(), $createdTenant->getSurname());
        $this->assertEquals($request->getZipCode(), $createdTenant->getZipCode());
        $this->assertEquals($request->getCity(), $createdTenant->getCity());
        $this->assertEquals($request->getCountry(), $createdTenant->getCountry());
        $this->assertEquals($request->getUsername(), $createdTenant->getUsername());
        $this->assertNotEmpty($createdTenant->getPasswordHash());
    }
}
