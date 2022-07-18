<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SupplierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupplierRepository::class)]
#[ApiResource]
class Supplier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Reference;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $taxeRate;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $bankDetails;

    #[ORM\Column(type: 'string', length: 255)]
    private $companyName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->Reference;
    }

    public function setReference(string $Reference): self
    {
        $this->Reference = $Reference;

        return $this;
    }

    public function getTaxeRate(): ?string
    {
        return $this->taxeRate;
    }

    public function setTaxeRate(?string $taxeRate): self
    {
        $this->taxeRate = $taxeRate;

        return $this;
    }

    public function getBankDetails(): ?string
    {
        return $this->bankDetails;
    }

    public function setBankDetails(?string $bankDetails): self
    {
        $this->bankDetails = $bankDetails;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }
}
