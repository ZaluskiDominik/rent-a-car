<?php

declare(strict_types=1);

namespace App\API\Common\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class BasicAuthHttpRequest implements ValidatedRequestInterface
{
    /**
     * @Assert\NotBlank(message="Basic auth authorization is required")
     * @Assert\Type(type="string", message="Basic auth authorization is required")
     */
    private $username;

    /**
     * @Assert\NotBlank(message="Basic auth authorization is required")
     * @Assert\Type(type="string", message="Basic auth authorization is required")
     */
    private $password;

    /** @return array<string, string|null> */
    public static function getInput(Request $request): array
    {
        return [
            'username' => $request->headers->get('php-auth-user'),
            'password' => $request->headers->get('php-auth-pw'),
        ];
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
