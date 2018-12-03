<?php

namespace App\Builder;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ScoreTable;
use App\Entity\Player;

class ScoreTableBuilder
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildTable()
    {
        $allPlayers = $this->em->getRepository(Player::class)->findAll();
        $date = new \DateTime();

        foreach ($allPlayers as $player)
        {
            $table = new ScoreTable();
            $table->setDate($date);
            $table->setPlayer($player);
            $this->em->persist($table);
        }
        $this->em->flush();
    }
}