<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RuleGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RuleGroupRepository::class)]
#[ApiResource]
class RuleGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $field;

    #[ORM\Column(type: 'string', length: 5)]
    private $operator;

    #[ORM\Column(type: 'string', length: 255)]
    private $value;

    #[ORM\Column(type: 'string', length: 1000, nullable: true)]
    private $description;

    #[ORM\ManyToMany(targetEntity: Campaign::class, inversedBy: 'ruleGroups')]
    private $fkCampaign;

    public function __construct()
    {
        $this->fkCampaign = new ArrayCollection();
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

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    public function setOperator(string $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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

    /**
     * @return Collection<int, Campaign>
     */
    public function getFkCampaign(): Collection
    {
        return $this->fkCampaign;
    }

    public function addFkCampaign(Campaign $fkCampaign): self
    {
        if (!$this->fkCampaign->contains($fkCampaign)) {
            $this->fkCampaign[] = $fkCampaign;
        }

        return $this;
    }

    public function removeFkCampaign(Campaign $fkCampaign): self
    {
        $this->fkCampaign->removeElement($fkCampaign);

        return $this;
    }
}
