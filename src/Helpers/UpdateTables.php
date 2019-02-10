<?php

declare(strict_types=1);

namespace App\Helpers;

use Doctrine\ORM\EntityManagerInterface;

class UpdateTables
{
    private $em;
    private static $pointsTable =
        [
          'win' => 2,
          'draw' => 1,
          'lose' => 0,
        ];

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function updateScoreTable(array $scores)
    {
        $winner = array_keys($scores, max($scores));
        $loser = array_keys($scores, min($scores));

        foreach ($scores as $id => $score) {
            $tableRow = $this->em->getRepository('App:ScoreTable')->findOneBy(['playerId' => $id]);
            $tableRow->setScore((int) $score);

            if ($winner === $loser) {
                $tableRow->setPoints($tableRow->getPoints() + UpdateTables::$pointsTable['draw']);
            } elseif ($winner[0] === $tableRow->getPlayerId()) {
                $tableRow->setPoints($tableRow->getPoints() + UpdateTables::$pointsTable['win']);
            } else ($loser[0] === $tableRow->getPlayerId()) {
                $tableRow->setPoints($tableRow->getPoints() + UpdateTables::$pointsTable['lose'])
            };

            $this->em->persist($tableRow);
        }
        $this->em->flush();
    }

    public function updatePairsTable(string $selector, string $duelId)
    {
        $duelRow = $this->em->getRepository('App:ShuffledPairs')->find($duelId);
        if ('revenges' === $selector) {
            $duelRow->setRevenge(1);
        }
        $duelRow->setDuel(1);
        $this->em->persist($duelRow);
        $this->em->flush();
    }
}
