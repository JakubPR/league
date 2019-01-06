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
     * @ORM\Column(type="object")
     */
    private $player1;

    /**
     * @ORM\Column(type="object")
     */
    private $player2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $played;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPlayer1(): ScoreTable
    {
        return $this->player1;
    }

    public function setPlayer1(ScoreTable $player1)
    {
        $this->player1 = $player1;

        return $this;
    }

    public function getPlayer2(): ScoreTable
    {
        return $this->player2;
    }

    public function setPlayer2(ScoreTable $player2)
    {
        $this->player2 = $player2;

        return $this;
    }

    public function getPlayed(): int
    {
        return $this->played;
    }

    public function setPlayed(int $played)
    {
        $this->played = $played;

        return $this;
    }
}
