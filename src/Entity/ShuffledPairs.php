<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShuffledPairsRepository")
 */
class ShuffledPairs
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
    private $player1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $player2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $played;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer1(): ?string
    {
        return $this->player1;
    }

    public function setPlayer1(string $player1): self
    {
        $this->player1 = $player1;

        return $this;
    }

    public function getPlayer2(): ?string
    {
        return $this->player2;
    }

    public function setPlayer2(string $player2): self
    {
        $this->player2 = $player2;

        return $this;
    }

    public function getPlayed(): int
    {
        return $this->played;
    }

    public function setPlayed(int $played): self
    {
        $this->played = $played;

        return $this;
    }
}
