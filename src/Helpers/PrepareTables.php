<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Entity\Player;
use App\Entity\ScoreTable;
use App\Entity\ShuffledPairs;
use Doctrine\ORM\EntityManagerInterface;

class PrepareTables
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function setData()
    {
        $players = $this->em->getRepository('App:Player')->findAll();

        $this->setPairsTable($players);
        $this->setScoreTable($players);
    }

    private function setScoreTable(array $players)
    {
        foreach ($players as $player) {
            /** @var Player $player */
            $tableRow = new ScoreTable();
            $tableRow->setPlayer($player);
            $tableRow->setPoints(0);
            $this->em->persist($tableRow);
        }
        $this->em->flush();
    }

    private function setPairsTable(array $players)
    {
        $pairs = $this->sortPlayers($players);

        foreach ($pairs as $pair) {
            $tableRow = new ShuffledPairs();
            $tableRow->setPlayer0($pair[0]);
            $tableRow->setPlayer1($pair[1]);
            $tableRow->setPlayed(0);
            $this->em->persist($tableRow);
        }
        $this->em->flush();
    }

    private function sortPlayers(array $players): array
    {
        shuffle($players);
        $result = array_chunk($players, 2);

        return $result;
    }
}
