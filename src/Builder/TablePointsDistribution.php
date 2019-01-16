<?php

namespace App\Builder;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ScoreTable;

class TablePointsDistribution
{
    private $em;
    private $scoreTable;

    public function __construct(EntityManagerInterface $em, ScoreTableBuilder $scoreTable)
    {
        $this->em = $em;
        $this->scoreTable = $scoreTable;
    }

    public function updateScoreTable($request)
    {
        dump($request);

        $tableData = $this->scoreTable->getTableDataForCurrentGame();
        foreach ($request as $playerId => $score) {
            foreach ($tableData as $data) {
                /** @var ScoreTable $data */
                $tablePlayer = $data->getPlayer()->getId();
                if ($tablePlayer === $playerId) {
                    $player = $this->em->getRepository(ScoreTable::class)->find($data->getId());
                }
            }
        }
    }
}