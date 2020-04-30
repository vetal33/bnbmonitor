<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoinRepository")
 */
class Coin
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shortName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flow", mappedBy="coin")
     */
    private $flows;

    public function __construct()
    {
        $this->flows = new ArrayCollection();
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

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection|Flow[]
     */
    public function getFlows(): Collection
    {
        return $this->flows;
    }

    public function addFlow(Flow $flow): self
    {
        if (!$this->flows->contains($flow)) {
            $this->flows[] = $flow;
            $flow->setCoin($this);
        }

        return $this;
    }

    public function removeFlow(Flow $flow): self
    {
        if ($this->flows->contains($flow)) {
            $this->flows->removeElement($flow);
            // set the owning side to null (unless already changed)
            if ($flow->getCoin() === $this) {
                $flow->setCoin(null);
            }
        }

        return $this;
    }
}
