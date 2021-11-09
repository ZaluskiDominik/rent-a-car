<?php

declare(strict_types=1);

namespace App\API\Tenant\Controller;

use App\API\Common\Response\RestApiResponse;
use App\API\Tenant\Extractor\TenantExtractor;
use App\API\Tenant\Request\CreateTenantHttpRequest;
use App\API\Tenant\Request\GetTenantHttpRequest;
use App\Module\Tenant\API\TenantAPI;
use App\Module\Tenant\Domain\Exception\EmailAlreadyExists;
use App\Module\Tenant\Domain\Exception\UsernameAlreadyExists;
use App\Module\Tenant\Domain\Request\CreateTenantRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class TenantController extends AbstractController
{
    private TenantAPI $tenantAPI;
    private TenantExtractor $tenantExtractor;

    public function __construct(
        TenantAPI $tenantAPI,
        TenantExtractor $tenantExtractor
    ) {
        $this->tenantAPI = $tenantAPI;
        $this->tenantExtractor = $tenantExtractor;
    }

    /**
     * @Route(name="api-tenant-create", methods={"POST"}, path="/tenants")
     */
    public function createAction(CreateTenantHttpRequest $request): Response
    {
        try {
            $tenant = $this->tenantAPI->create(new CreateTenantRequest(
                $request->getEmail(),
                $request->getName(),
                $request->getSurname(),
                $request->getZipCode(),
                $request->getCountry(),
                $request->getCountry(),
                $request->getUsername(),
                $request->getPassword(),
                $request->getAge()
            ));
        } catch (EmailAlreadyExists | UsernameAlreadyExists $e) {
            return RestApiResponse::error($e->getMessage(), 409);
        }

        return RestApiResponse::success(
            $this->tenantExtractor->extract($tenant),
            201
        );
    }

    /**
     * @Route(name="api-tenant-get", methods={"GET"}, path="/tenants")
     */
    public function getAction(GetTenantHttpRequest $request): Response
    {
        $tenant = $this->tenantAPI->getByUsernameAndPassword($request->getUsername(), $request->getPassword());
        if (!$tenant) {
            return RestApiResponse::basicAuthUnauthorized();
        }

        return RestApiResponse::success($this->tenantExtractor->extract($tenant));
    }
}
