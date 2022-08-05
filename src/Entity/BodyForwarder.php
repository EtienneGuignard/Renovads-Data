<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BodyForwarderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BodyForwarderRepository::class)]
#[ApiResource]
class BodyForwarder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $input = null;

    #[ORM\Column(length: 255)]
    private ?string $outpout = null;

    #[ORM\ManyToOne(inversedBy: 'bodyForwarders')]
    private ?Forwarder $fkForwarder = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getInput(): ?string
    {
        return $this->input;
    }

    public function setInput(string $input): self
    {
        $this->input = $input;

        return $this;
    }

    public function getOutpout(): ?string
    {
        return $this->outpout;
    }

    public function setOutpout(string $outpout): self
    {
        $this->outpout = $outpout;

        return $this;
    }

    public function getFkForwarder(): ?Forwarder
    {
        return $this->fkForwarder;
    }

    public function setFkForwarder(?Forwarder $fkForwarder): self
    {
        $this->fkForwarder = $fkForwarder;

        return $this;
    }
}
