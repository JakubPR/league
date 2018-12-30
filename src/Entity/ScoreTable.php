<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScoreTableRepository")
 */
class ScoreTable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="array")
     */
    private $player;

    /**
     * @ORM\Column(type="integer")
     */
    private $points;

    /**
     * @ORM\Column(type="integer")
     */
    private $gameId;

    public function getGameId()
    {
        return $this->gameId;
    }

    public function setGameId($gameId): void
    {
        $this->gameId = $gameId;
    }


    public function getPoints()
    {
        return $this->points;
    }

    public function setPoints($points): void
    {
        $this->points = $points;
    }

    public function getPlayer()
    {
        return $this->player;
    }

    public function setPlayer($player): void
    {
        $this->player = $player;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
