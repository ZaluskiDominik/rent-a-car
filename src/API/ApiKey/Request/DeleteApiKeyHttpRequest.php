<?php

declare(strict_types=1);

namespace App\API\ApiKey\Request;

use App\API\Common\Request\BasicAuthHttpRequest;
use Symfony\Component\HttpFoundation\Request;

final class DeleteApiKeyHttpRequest extends BasicAuthHttpRequest
{
    private string $apiKey;

    public static function getInput(Request $request): array
    {
        return array_merge(
            parent::getInput($request),
            ['apiKey' => $request->attributes->get('apiKey')]
        );
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}
