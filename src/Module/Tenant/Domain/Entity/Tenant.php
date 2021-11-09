<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Module\Tenant\Domain\Repository\TenantRepositoryInterface;

/**
 * @ORM\Entity(repositoryClass=TenantRepositoryInterface::class)
 */
final class Tenant
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36)
     */
    private string $id;

    /**
     * @ORM\Column(type="string", unique=true, length=255)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $surname;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private string $zipCode;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $city;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private string $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $passwordHash;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $age;

    /**
     * @var Collection<int, ApiKey>
     * @ORM\OneToMany(targetEntity="ApiKey", mappedBy="tenant")
     */
    private Collection $apiKeys;

    /** @param Collection<int, ApiKey>|null $apiKeys */
    public function __construct(
        string $id,
        string $email,
        string $name,
        string $surname,
        string $zipCode,
        string $city,
        string $country,
        string $username,
        string $passwordHash,
        ?int $age = null,
        ?Collection $apiKeys = null
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->surname = $surname;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->country = $country;
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->age = $age;
        $this->apiKeys = $apiKeys ?? new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
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

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    /** @return Collection<int, ApiKey> */
    public function getApiKeys(): Collection
    {
        return $this->apiKeys;
    }
}
