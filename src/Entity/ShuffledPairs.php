<?php

declare(strict_types=1);

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
    private $player0;

    /**
     * @ORM\Column(type="integer")
     */
    private $duel;

    /**
     * @ORM\Column(type="integer")
     */
    private $revenge;

    public function getId()
    {
        return $this->id;
    }

    public function getPlayer1(): Player
    {
        return $this->player1;
    }

    public function setPlayer1(Player $player1)
    {
        $this->player1 = $player1;

        return $this;
    }

    public function getPlayer0(): Player
    {
        return $this->player0;
    }

    public function setPlayer0(Player $player0)
    {
        $this->player0 = $player0;

        return $this;
    }

    public function getDuel(): int
    {
        return $this->duel;
    }

    public function setDuel(int $duel)
    {
        $this->duel = $duel;

        return $this;
    }

    public function getRevenge(): int
    {
        return $this->revenge;
    }

    public function setRevenge(int $revenge)
    {
        $this->revenge = $revenge;

        return $this;
    }
}
