<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DataAcrossHeaderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DataAcrossHeaderRepository::class)]
#[ApiResource]
class DataAcrossHeader
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $secret = null;

    #[ORM\Column(length: 7)]
    private ?string $idProgramma = null;

    #[ORM\Column(length: 500)]
    private ?string $uri = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Campaign $campaignId = null;

    #[ORM\Column(length: 255)]
    private ?string $Url = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSecret(): ?string
    {
        return $this->secret;
    }

    public function setSecret(string $secret): self
    {
        $this->secret = $secret;

        return $this;
    }

    public function getIdProgramma(): ?string
    {
        return $this->idProgramma;
    }

    public function setIdProgramma(string $idProgramma): self
    {
        $this->idProgramma = $idProgramma;

        return $this;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    public function getCampaignId(): ?Campaign
    {
        return $this->campaignId;
    }

    public function setCampaignId(?Campaign $campaignId): self
    {
        $this->campaignId = $campaignId;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->Url;
    }

    public function setUrl(string $Url): self
    {
        $this->Url = $Url;

        return $this;
    }
}
