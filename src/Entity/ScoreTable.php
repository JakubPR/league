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
     * @ORM\Column(type="object")
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

    public function getGameId(): int
    {
        return $this->gameId;
    }

    public function setGameId(int $gameId)
    {
        $this->gameId = $gameId;
    }


    public function getPoints()
    {
        return $this->points;
    }

    public function setPoints(int $points)
    {
        $this->points = $points;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player)
    {
        $this->player = $player;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
