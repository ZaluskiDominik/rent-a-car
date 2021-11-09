<?php

declare(strict_types=1);

namespace App\Module\Tenant\Domain\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Module\Tenant\Domain\Repository\ApiKeyRepositoryInterface;

/**
 * @ORM\Entity(repositoryClass=ApiKeyRepositoryInterface::class)
 */
final class ApiKey
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=64)
     */
    private string $apiKey;

    /**
     * @ORM\ManyToOne(targetEntity="Tenant", inversedBy="apiKeys")
     * @ORM\JoinColumn(nullable=false)
     */
    private Tenant $tenant;

    /**
     * @ORM\Column(type="integer")
     */
    private int $createdAt;

    public function __construct(string $apiKey, Tenant $tenant)
    {
        $this->apiKey = $apiKey;
        $this->tenant = $tenant;
        $this->createdAt = (new DateTime())->getTimestamp();
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getTenant(): Tenant
    {
        return $this->tenant;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }
}
