<?php

namespace App\Builder;

use App\Entity\ScoreTable;
use Doctrine\ORM\EntityManagerInterface;

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
        $duelId = $request['duelId'];
        unset($request['duelId']);

        $biggest = (max($request));
        $smallest = (min($request));

        $winner = (array_search($biggest, $request));
        $loser = (array_search($smallest, $request));

        $tableData = $this->scoreTable->getTableDataForCurrentGame();
        foreach ($request as $playerId => $score) {
            foreach ($tableData as $data) {

                /** @var ScoreTable $data */
                $tablePlayer = $data->getPlayer()->getId();

                if ($tablePlayer === $playerId) {

                    $points = 1;
                    if ($playerId === $winner && $winner != $loser) {
                        $points = 2;
                    } elseif ($playerId === $loser && $loser != $winner) {
                        $points = 0;
                    }
                    $data->setPoints($points);
                    $this->em->persist($data);
                }
            }
        }
        $this->setDuelAsPlayed($duelId);
        //$this->em->flush();
    }

    private function setDuelAsPlayed($duelId)
    {
        $duel = $this->em->getRepository('App:ShuffledPairs')->find(['id' => $duelId]);
        $duel->setPlayed(1);
    }
}