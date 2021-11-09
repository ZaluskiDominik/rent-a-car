<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Request;

final class CreateTenantRequest
{
    private string $email;
    private string $name;
    private string $surname;
    private string $zipCode;
    private string $city;
    private string $country;
    private string $username;
    private string $password;
    private ?int $age;

    public function __construct(
        string $email,
        string $name,
        string $surname,
        string $zipCode,
        string $city,
        string $country,
        string $username,
        string $password,
        ?int $age = null
    ) {
        $this->email = $email;
        $this->name = $name;
        $this->surname = $surname;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->country = $country;
        $this->username = $username;
        $this->password = $password;
        $this->age = $age;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }
}
