<?php

namespace App\Builder;

use App\Repository\ScoreTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ScoreTable;
use App\Entity\Player;

class ScoreTableBuilder
{
    private $em;
    private $date;
    private $repo;

    public function __construct(EntityManagerInterface $em, ScoreTableRepository $repo)
    {
        $this->repo = $repo;
        $this->em = $em;
        $this->date = new \DateTime();
    }

    public function buildTable()
    {
        $allPlayers = $this->getAllPlayers();

        $gameId = $this->calculateNewGameId();

        foreach ($allPlayers as $player)
        {
            $table = new ScoreTable();

            $table->setDate($this->date);
            $table->setPlayer($player);
            $table->setScore(0);
            $table->setGameId($gameId);
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
        return $this->repo->findOneBy(['date' => $this->date]);
    }

    public function calculateNewGameId()
    {
        /** @var ScoreTable $tableData */
        $tableData = $this->getLastAddedGameId();

        if (!$tableData) {
            return 1;
        }
        return $tableData[0]->getGameId()+1;
    }

    public function getLastAddedGameId()
    {
        return $this->repo->findLastAddedId();
    }
}