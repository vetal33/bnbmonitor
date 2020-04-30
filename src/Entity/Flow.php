<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FlowRepository")
 */
class Flow
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="float")
     */
    private $volume;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberTrades;

    /**
     * @ORM\Column(type="integer")
     */
    private $interval;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endOfInterval;

    /**
     * @ORM\Column(type="datetime")
     */
    private $receivedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Coin", inversedBy="flows")
     * @ORM\JoinColumn(nullable=false)
     */
    private $coin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getVolume(): ?float
    {
        return $this->volume;
    }

    public function setVolume(float $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getNumberTrades(): ?int
    {
        return $this->numberTrades;
    }

    public function setNumberTrades(int $numberTrades): self
    {
        $this->numberTrades = $numberTrades;

        return $this;
    }

    public function getInterval(): ?int
    {
        return $this->interval;
    }

    public function setInterval(int $interval): self
    {
        $this->interval = $interval;

        return $this;
    }

    public function getEndOfInterval(): ?\DateTimeInterface
    {
        return $this->endOfInterval;
    }

    public function setEndOfInterval(\DateTimeInterface $endOfInterval): self
    {
        $this->endOfInterval = $endOfInterval;

        return $this;
    }

    public function getReceivedAt(): ?\DateTimeInterface
    {
        return $this->receivedAt;
    }

    public function setReceivedAt(\DateTimeInterface $receivedAt): self
    {
        $this->receivedAt = $receivedAt;

        return $this;
    }

    public function getCoin(): ?Coin
    {
        return $this->coin;
    }

    public function setCoin(?Coin $coin): self
    {
        $this->coin = $coin;

        return $this;
    }
}
