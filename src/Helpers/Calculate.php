<?php

declare(strict_types=1);

namespace App\Helpers;

use Doctrine\ORM\EntityManagerInterface;

class Calculate
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

    public function calculatePoints(array $scores)
    {
        $winner = array_keys($scores, max($scores));
        $loser = array_keys($scores, min($scores));

        foreach ($scores as $id => $score) {
            $tableRow = $this->em->getRepository('App:ScoreTable')->findOneBy(['playerId' => $id]);
            $tableRow->setScore((int) $score);
            if ($winner[0] === $tableRow->getPlayerId()) {
                $tableRow->setPoints(Calculate::$pointsTable['win']);
            }
            if ($loser[0] === $tableRow->getPlayerId()) {
                $tableRow->setPoints(Calculate::$pointsTable['lose']);
            }
            if ($winner === $loser) {
                $tableRow->setPoints(Calculate::$pointsTable['draw']);
            }
            $this->em->persist($tableRow);
        }
        //$this->em->flush();
    }
}
