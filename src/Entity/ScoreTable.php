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
     * @ORM\Column(type="string")
     */
    private $playerName;

    /**
     * @ORM\Column(type="integer")
     */
    private $playerId;

    /**
     * @ORM\Column(type="integer")
     */
    private $points;

    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    public function getId()
    {
        return $this->id;
    }

    public function getPlayerId()
    {
        return $this->playerId;
    }

    public function setPlayerId(int $playerId): ScoreTable
    {
        $this->playerId = $playerId;

        return $this;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function setPoints(int $points): ScoreTable
    {
        $this->points = $points;

        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): ScoreTable
    {
        $this->score = $score;

        return $this;
    }

    public function getPlayerName()
    {
        return $this->playerName;
    }

    public function setPlayerName(string $playerName): ScoreTable
    {
        $this->playerName = $playerName;

        return $this;
    }
}
