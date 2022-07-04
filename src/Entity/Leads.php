<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LeadsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeadsRepository::class)]
#[ApiResource]
class Leads
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstname;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dob;

    #[ORM\OneToMany(mappedBy: 'leadId', targetEntity: CampaignLeads::class)]
    private $fkLeads;

    public function __construct()
    {
        $this->campaigns = new ArrayCollection();
        $this->fkLeads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(?\DateTimeInterface $dob): self
    {
        $this->dob = $dob;

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
            $fkLead->setLeadId($this);
        }

        return $this;
    }

    public function removeFkLead(CampaignLeads $fkLead): self
    {
        if ($this->fkLeads->removeElement($fkLead)) {
            // set the owning side to null (unless already changed)
            if ($fkLead->getLeadId() === $this) {
                $fkLead->setLeadId(null);
            }
        }

        return $this;
    }
}
