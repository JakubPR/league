<?php

namespace App\Builder;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ScoreTable;
use App\Entity\Player;

class ScoreTableBuilder
{
    private $em;
    private $date;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->date = new \DateTime();
    }

    public function buildTable()
    {
        $allPlayers = $this->getAllPlayers();

        foreach ($allPlayers as $player)
        {
            $table = new ScoreTable();

            $table->setDate($this->date);
            $table->setPlayer($player);
            $table->setScore(0);
            $this->em->persist($table);
        }
        $this->em->flush();
    }

    public function getAllPlayers()
    {
        return $this->em->getRepository(Player::class)->findAll();
    }

    public function checkIfTableHasBeenCreatedToday()
    {
        return $this->em->getRepository(ScoreTable::class)->findOneBy(['date' => $this->date]);
    }

}