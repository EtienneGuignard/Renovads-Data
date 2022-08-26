<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LeadsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\LeadPersist;

#[ORM\Entity(repositoryClass: LeadsRepository::class)]
#[ApiResource(
    collectionOperations: [
        'post' => [
            'path' => '/lead/v2',
            'controller' => LeadPersist::class,
            'serialize'=>true,
            
        ],
    ],
    
    itemOperations: [
    'get',
    'delete',
    'put',
    'put_upadated_at' => [
        'method' => 'PUT',
        'path' => '/aricle/{id}/updated-at',
        'controller' => LeadPersist::class,
    ],
    'patch',
])]
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

    #[ORM\Column(type: 'date', nullable: true)]
    private $dob;

    #[ORM\OneToMany(mappedBy: 'leadId', targetEntity: CampaignLeads::class, cascade: ['persist'])]
    private $fkCampaigns;

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

    #[ORM\Column]
    private ?bool $confirmPrivacy = null;

    #[ORM\Column(nullable: true)]
    private ?bool $confirmPartners = null;

    #[ORM\Column(type: 'string', length: 1000, nullable: true)]
    private $url;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $job;

    #[ORM\Column(type: 'string', length: 3, nullable: true)]
    private $children;

    #[ORM\Column(type: 'datetime',  nullable: true)]
    private $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $lastUpdated;

    #[ORM\ManyToOne(inversedBy: 'fk_leadId')]
    private ?Supplier $supplier = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column]
    private ?int $sid = null;

    #[ORM\Column(length: 45)]
    private ?string $ip = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $region = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $paramInfo1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $paramInfo2 = null;

    public function __construct()
    {
        $this->campaigns = new ArrayCollection();
        $this->fkCampaigns = new ArrayCollection();
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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
    public function getfkCampaigns(): Collection
    {
        return $this->fkCampaigns;
    }

    public function addfkCampaign(CampaignLeads $fkCampaign): self
    {
        if (!$this->fkCampaigns->contains($fkCampaign)) {
            $this->fkCampaigns[] = $fkCampaign;
            $fkCampaign->setLeadId($this);
        }

        return $this;
    }

    public function removefkCampaign(CampaignLeads $fkCampaign): self
    {
        if ($this->fkCampaigns->removeElement($fkCampaign)) {
            // set the owning side to null (unless already changed)
            if ($fkCampaign->getLeadId() === $this) {
                $fkCampaign->setLeadId(null);
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

    public function getConfirmPrivacy(): ?bool
    {
        return $this->confirmPrivacy;
    }

    public function setConfirmPrivacy(string $confirmPrivacy): self
    {
        $this->confirmPrivacy = $confirmPrivacy;

        return $this;
    }

    public function getConfirmPartners(): ?bool
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

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLastUpdated(): ?\DateTimeInterface
    {
        return $this->lastUpdated;
    }

    public function setLastUpdated(?\DateTimeInterface $lastUpdated): self
    {
        $this->lastUpdated = $lastUpdated;

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): self
    {
        $this->supplier = $supplier;

        return $this;
    }

    public function getSid(): ?int
    {
        return $this->sid;
    }

    public function setSid(int $sid): self
    {
        $this->sid = $sid;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getParamInfo1(): ?string
    {
        return $this->paramInfo1;
    }

    public function setParamInfo1(?string $paramInfo1): self
    {
        $this->paramInfo1 = $paramInfo1;

        return $this;
    }

    public function getParamInfo2(): ?string
    {
        return $this->paramInfo2;
    }

    public function setParamInfo2(?string $paramInfo2): self
    {
        $this->paramInfo2 = $paramInfo2;

        return $this;
    }

   
}
