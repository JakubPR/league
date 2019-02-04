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
    private $played;

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
