<?php

declare(strict_types=1);

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
     * @ORM\Column(type="object")
     */
    private $player;

    /**
     * @ORM\Column(type="integer")
     */
    private $points;

    public function getId()
    {
        return $this->id;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function setPoints(int $points): ScoreTable
    {
        $this->points = $points;

        return $this;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setPlayer(Player $player): ScoreTable
    {
        $this->player = $player;

        return $this;
    }
}
