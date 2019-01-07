<?php

namespace App\Builder;

use App\Entity\ShuffledPairs;
use App\Repository\ScoreTableRepository;
use Doctrine\ORM\EntityManagerInterface;

class PairsTableBuilder
{
    private $scoreTableRepo;
    private $tableBuilder;
    private $em;

    function __construct(ScoreTableBuilder $tableBuilder, ScoreTableRepository $scoreTableRepo, EntityManagerInterface $em)
    {
        $this->tableBuilder = $tableBuilder;
        $this->scoreTableRepo = $scoreTableRepo;
        $this->em = $em;
    }

    public function preparePairsTable()
    {
        $this->removeDataFromTable();
        $this->saveDataToPairsTable();
    }

    private function getTableDataForCurrentGame() : array
    {
        $lastGameId = $this->tableBuilder->getLastAddedGameId();
        return $this->scoreTableRepo->findAllCurrentData($lastGameId);
    }

    private function shuffleAndChunkData() : array
    {
        $tableData = $this->getTableDataForCurrentGame();
        shuffle($tableData);
        $shuffledData = array_chunk($tableData,2);
        return $shuffledData;
    }

    private function saveDataToPairsTable(): void
    {
        $dataToSave = $this->shuffleAndChunkData();

        foreach ($dataToSave as $array => $pair)
        {
            $newPair = New ShuffledPairs();
            $newPair->setPlayer1($pair[0]);
            $newPair->setPlayer2($pair[1]);
            $newPair->setPlayed(0);
            $this->em->persist($newPair);
        }
        $this->em->flush();

    }

    private function getDataFromPairsTable(): array
    {
        return $this->em->getRepository('App:ShuffledPairs')->findAll();
    }

    private function removeDataFromTable()
    {
        if (!empty($this->getDataFromPairsTable()))
        {
            foreach ($this->getDataFromPairsTable() as $dataToRemove)
            {
                $this->em->remove($dataToRemove);
            }
            $this->em->flush();
        }
    }
}