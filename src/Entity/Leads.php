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

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $address_1;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $address_2;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $city;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private $zip;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $privacyPolicy;

    #[ORM\Column(type: 'string', length: 45)]
    private $confirmPrivacy;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private $confirmPartners;

    #[ORM\Column(type: 'string', length: 1000, nullable: true)]
    private $url;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $job;

    #[ORM\Column(type: 'string', length: 3, nullable: true)]
    private $children;

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

    public function getAddress1(): ?string
    {
        return $this->address_1;
    }

    public function setAddress1(?string $address_1): self
    {
        $this->address_1 = $address_1;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address_2;
    }

    public function setAddress2(?string $address_2): self
    {
        $this->address_2 = $address_2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getPrivacyPolicy(): ?string
    {
        return $this->privacyPolicy;
    }

    public function setPrivacyPolicy(?string $privacyPolicy): self
    {
        $this->privacyPolicy = $privacyPolicy;

        return $this;
    }

    public function getConfirmPrivacy(): ?string
    {
        return $this->confirmPrivacy;
    }

    public function setConfirmPrivacy(string $confirmPrivacy): self
    {
        $this->confirmPrivacy = $confirmPrivacy;

        return $this;
    }

    public function getConfirmPartners(): ?string
    {
        return $this->confirmPartners;
    }

    public function setConfirmPartners(?string $confirmPartners): self
    {
        $this->confirmPartners = $confirmPartners;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(?string $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function getChildren(): ?string
    {
        return $this->children;
    }

    public function setChildren(?string $children): self
    {
        $this->children = $children;

        return $this;
    }
}
