<?php

declare(strict_types=1);

namespace App\API\ApiKey\Controller;

use App\API\ApiKey\Extractor\ApiKeyExtractor;
use App\API\ApiKey\Request\DeleteApiKeyHttpRequest;
use App\API\Common\Request\BasicAuthHttpRequest;
use App\API\Common\Response\RestApiResponse;
use App\Module\Tenant\API\ApiKeyAPI;
use App\Module\Tenant\API\TenantAPI;
use App\Module\Tenant\Domain\Exception\ApiKeyNotFound;
use App\Module\Tenant\Domain\Exception\MaxApiKeysCountReached;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ApiKeyController extends AbstractController
{
    private ApiKeyAPI $apiKeyAPI;
    private TenantAPI $tenantAPI;
    private ApiKeyExtractor $apiKeyExtractor;

    public function __construct(ApiKeyAPI $apiKeyAPI, TenantAPI $tenantAPI, ApiKeyExtractor $apiKeyExtractor)
    {
        $this->apiKeyAPI = $apiKeyAPI;
        $this->tenantAPI = $tenantAPI;
        $this->apiKeyExtractor = $apiKeyExtractor;
    }

    /**
     * @Route(name="api-apikey-create", methods={"POST"}, path="/apikeys")
     */
    public function createAction(BasicAuthHttpRequest $request): Response
    {
        $tenant = $this->tenantAPI->getByUsernameAndPassword($request->getUsername(), $request->getPassword());
        if (!$tenant) {
            return RestApiResponse::basicAuthUnauthorized();
        }

        try {
            $apiKey = $this->apiKeyAPI->create($tenant->getId());
        } catch (MaxApiKeysCountReached $e) {
            return RestApiResponse::error($e->getMessage(), 422);
        }

        return RestApiResponse::success(['apiKey' => $this->apiKeyExtractor->extract($apiKey)], 201);
    }

    /**
     * @Route(name="api-apikey-list", methods={"GET"}, path="/apikeys")
     */
    public function listAction(BasicAuthHttpRequest $request): Response
    {
        $tenant = $this->tenantAPI->getByUsernameAndPassword($request->getUsername(), $request->getPassword());
        if (!$tenant) {
            return RestApiResponse::basicAuthUnauthorized();
        }

        $apiKeys = $this->apiKeyAPI->list($tenant->getId());

        return RestApiResponse::success($this->apiKeyExtractor->extractList($apiKeys));
    }

    /**
     * @Route(name="api-apikey-delete", methods={"DELETE"}, path="/apikeys/{apiKey}")
     */
    public function deleteAction(DeleteApiKeyHttpRequest $request): Response
    {
        $tenant = $this->tenantAPI->getByUsernameAndPassword($request->getUsername(), $request->getPassword());
        if (!$tenant) {
            return RestApiResponse::basicAuthUnauthorized();
        }

        try {
            $this->apiKeyAPI->delete($request->getApiKey());
        } catch (ApiKeyNotFound $e) {
            return RestApiResponse::error($e->getMessage(), 404);
        }

        return RestApiResponse::success([]);
    }
}
