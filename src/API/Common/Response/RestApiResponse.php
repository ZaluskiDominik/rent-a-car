<?php

declare(strict_types=1);

namespace App\API\Common\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class RestApiResponse
{
    /**
     * @param array<string|int, mixed> $data
     */
    public static function success(array $data, int $statusCode = 200): JsonResponse
    {
        return new JsonResponse(['data' => $data], $statusCode);
    }

    public static function basicAuthUnauthorized(): JsonResponse
    {
        return RestApiResponse::error('Invalid basic auth credentials', 401);
    }

    public static function error(string $message, int $statusCode = 400): JsonResponse
    {
        return new JsonResponse(['errors' => [$message]], $statusCode);
    }

    public static function fromConstraintViolationList(
        ConstraintViolationListInterface $constraintViolationList,
        int $statusCode = 400
    ): JsonResponse {
        $errors = [];
        foreach ($constraintViolationList as $constraintViolation) {
            $errors[] = $constraintViolation->getPropertyPath() . ': ' . $constraintViolation->getMessage();
        }

        return new JsonResponse(['errors' => $errors], $statusCode);
    }

    private function __construct()
    {
    }
}
