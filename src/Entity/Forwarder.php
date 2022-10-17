<?php

namespace App\Entity;

use App\Repository\ForwarderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForwarderRepository::class)]
class Forwarder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 1000)]
    private $url;

    #[ORM\ManyToOne(inversedBy: 'forwarders')]
    private ?Campaign $fkCampaign = null;

    #[ORM\OneToMany(mappedBy: 'fkForwarder', targetEntity: BodyForwarder::class, cascade:['remove'])]
    private Collection $bodyForwarders;

    #[ORM\Column(length: 5)]
    private ?string $method = null;

    public function __construct()
    {
        $this->bodyForwarders = new ArrayCollection();
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }


    public function getFkCampaign(): ?Campaign
    {
        return $this->fkCampaign;
    }

    public function setFkCampaign(?Campaign $fkCampaign): self
    {
        $this->fkCampaign = $fkCampaign;

        return $this;
    }

    /**
     * @return Collection<int, BodyForwarder>
     */
    public function getBodyForwarders(): Collection
    {
        return $this->bodyForwarders;
    }

    public function addBodyForwarder(BodyForwarder $bodyForwarder): self
    {
        if (!$this->bodyForwarders->contains($bodyForwarder)) {
            $this->bodyForwarders->add($bodyForwarder);
            $bodyForwarder->setFkForwarder($this);
        }

        return $this;
    }

    public function removeBodyForwarder(BodyForwarder $bodyForwarder): self
    {
        if ($this->bodyForwarders->removeElement($bodyForwarder)) {
            // set the owning side to null (unless already changed)
            if ($bodyForwarder->getFkForwarder() === $this) {
                $bodyForwarder->setFkForwarder(null);
            }
        }

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }
}
