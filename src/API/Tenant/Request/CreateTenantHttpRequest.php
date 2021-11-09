<?php

declare(strict_types=1);

namespace App\API\Tenant\Request;

use App\API\Common\Request\PreFilterRequestInterface;
use App\API\Common\Request\PropertyFilter;
use App\API\Common\Request\ValidatedRequestInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateTenantHttpRequest implements ValidatedRequestInterface, PreFilterRequestInterface
{
    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string"),
     * @Assert\Email
     */
    private $email;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string"),
     * @Assert\Length(max=50)
     */
    private $name;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string"),
     * @Assert\Length(max=50)
     */
    private $surname;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string"),
     * @Assert\Length(max=10)
     */
    private $zipCode;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string"),
     * @Assert\Length(max=50)
     */
    private $city;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string"),
     * @Assert\Choice({"DE", "PL", "CZ", "SK"})
     */
    private $country;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string"),
     * @Assert\Length(min=8, max=50)
     */
    private $username;

    /**
     * @Assert\NotBlank
     * @Assert\Type(type="string"),
     * @Assert\Length(min=8, max=50)
     */
    private $password;

    /**
     * @Assert\Sequentially({
     *      @Assert\Type(type="int"),
     *      @Assert\LessThan(value="150"),
     *      @Assert\GreaterThanOrEqual(value="18")
     * })
     */
    private $age = null;

    public static function getInput(Request $request): array
    {
        return $request->toArray();
    }

    public function preFilter(): void
    {
        $this->email = PropertyFilter::trim($this->email);
        $this->name = PropertyFilter::trim($this->name);
        $this->surname = PropertyFilter::trim($this->surname);
        $this->zipCode = PropertyFilter::trim($this->zipCode);
        $this->city = PropertyFilter::trim($this->city);
        $this->country = PropertyFilter::trim($this->country);
        $this->username = PropertyFilter::trim($this->username);
        $this->password = PropertyFilter::trim($this->password);
        $this->age = PropertyFilter::toInt(PropertyFilter::trim($this->age));
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
