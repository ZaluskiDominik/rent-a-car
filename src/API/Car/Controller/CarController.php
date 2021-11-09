<?php

declare(strict_types=1);

namespace App\API\Car\Controller;

use App\API\Common\Response\RestApiResponse;
use App\API\Tenant\Request\CreateTenantHttpRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CarController extends AbstractController
{
    /**
     * @Route(name="api-car-list", methods={"GET"}, path="/cars")
     */
    public function listAction(CreateTenantHttpRequest $request): Response
    {


        return RestApiResponse::success(

        );
    }
}
