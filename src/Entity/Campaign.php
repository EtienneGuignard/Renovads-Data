<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CampaignRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampaignRepository::class)]
#[ApiResource]
class Campaign
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $client;

    #[ORM\Column(type: 'string', length: 1000, nullable: true)]
    private $image;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $revenuePerLead;

    #[ORM\Column(type: 'string', length: 1000, nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $Country;

    #[ORM\Column(type: 'string', length: 255)]
    private $currency;

    #[ORM\ManyToMany(targetEntity: RuleGroup::class, mappedBy: 'fkCampaign')]
    private $ruleGroups;

    #[ORM\OneToMany(mappedBy: 'campaignId', targetEntity: CampaignLeads::class)]
    private $fkLeads;

    public function __construct()
    {
        $this->idLead = new ArrayCollection();
        $this->ruleGroups = new ArrayCollection();
        $this->fkLeads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(?string $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getRevenuePerLead(): ?string
    {
        return $this->revenuePerLead;
    }

    public function setRevenuePerLead(string $revenuePerLead): self
    {
        $this->revenuePerLead = $revenuePerLead;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->Country;
    }

    public function setCountry(string $Country): self
    {
        $this->Country = $Country;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return Collection<int, RuleGroup>
     */
    public function getRuleGroups(): Collection
    {
        return $this->ruleGroups;
    }

    public function addRuleGroup(RuleGroup $ruleGroup): self
    {
        if (!$this->ruleGroups->contains($ruleGroup)) {
            $this->ruleGroups[] = $ruleGroup;
            $ruleGroup->addFkCampaign($this);
        }

        return $this;
    }

    public function removeRuleGroup(RuleGroup $ruleGroup): self
    {
        if ($this->ruleGroups->removeElement($ruleGroup)) {
            $ruleGroup->removeFkCampaign($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, CampaignLeads>
     */
    public function getFkLeads(): Collection
    {
        return $this->fkLeads;
    }

    public function addFkLead(CampaignLeads $fkLead): self
    {
        if (!$this->fkLeads->contains($fkLead)) {
            $this->fkLeads[] = $fkLead;
            $fkLead->setCampaignId($this);
        }

        return $this;
    }

    public function removeFkLead(CampaignLeads $fkLead): self
    {
        if ($this->fkLeads->removeElement($fkLead)) {
            // set the owning side to null (unless already changed)
            if ($fkLead->getCampaignId() === $this) {
                $fkLead->setCampaignId(null);
            }
        }

        return $this;
    }
}
