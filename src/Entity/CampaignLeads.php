<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CampaignLeadsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampaignLeadsRepository::class)]
#[ApiResource]
class CampaignLeads
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Campaign::class, inversedBy: 'fkLeads', cascade: ['persist'])]
    private $campaignId;

    #[ORM\ManyToOne(targetEntity: Leads::class, inversedBy: 'fkCampaigns', cascade: ['persist'])]
    private $leadId;

    #[ORM\Column(type: 'string', length: 255)]
    private $Status;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLeadId(): ?Leads
    {
        return $this->leadId;
    }

    public function setLeadId(?Leads $leadId): self
    {
        $this->leadId = $leadId;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): self
    {
        $this->Status = $Status;

        return $this;
    }
}
