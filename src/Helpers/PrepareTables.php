<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Entity\Player;
use App\Entity\ScoreTable;
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
        $this->setScoreTable();
    }

    private function setScoreTable()
    {
        $players = $this->em->getRepository('player')->findAll();

        foreach ($players as $player) {
            /** @var Player $player */
            $tableRow = new ScoreTable();
            $tableRow->setPlayer($player);
            $tableRow->setPoints(0);
            $this->em->persist($tableRow);
        }
        $this->em->flush();
    }
}
