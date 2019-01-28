<?php

namespace App\Builder;

use App\Entity\ScoreTable;
use App\Entity\ShuffledPairs;
use App\Repository\ScoreTableRepository;
use Doctrine\ORM\EntityManagerInterface;

class PairsTableBuilder
{
    private $scoreTableRepo;
    private $scoreTable;
    private $tableBuilder;
    private $settingsTable;
    private $em;

    function __construct
    (
        ScoreTableBuilder $scoreTable,
        EntityManagerInterface $em,
        SettingsTableBuilder $settingsTable,
        ScoreTableRepository $scoreTableRepo
    ) {
        $this->tableBuilder = $scoreTable;
        $this->scoreTable = $scoreTable;
        $this->scoreTableRepo = $scoreTableRepo;
        $this->em = $em;
        $this->settingsTable = $settingsTable;
    }

    private function shuffleAndChunkData() : array
    {
        $tableData = $this->scoreTableRepo
            ->findAllCurrentData($this->scoreTable->getLastAddedGameId());
        shuffle($tableData);
        $shuffledData = array_chunk($tableData, 2);
        return $shuffledData;
    }

    public function setDataToPairsTable()
    {
        $dataToSave = $this->shuffleAndChunkData();

        foreach ($dataToSave as $array => $pair)
        {
            /** @var  $pair ScoreTable */
            $newPair = New ShuffledPairs();
            $newPair->setPlayer1($pair[0]->getPlayer());
            $newPair->setPlayer2($pair[1]->getPlayer());
            $newPair->setPlayed(0);
            $this->em->persist($newPair);
        }
        $this->em->flush();
    }

    public function getDataFromPairsTable()
    {
        return $this->em->getRepository(ShuffledPairs::class)->findAll();
    }

    public function getPairWithoutDuel()
    {
        return $this->em->getRepository(ShuffledPairs::class)->findBy(['played' => 0]);
    }

    public function deleteDataFromPairsTable()
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