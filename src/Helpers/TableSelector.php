<?php

declare(strict_types=1);

namespace App\Helpers;

use Doctrine\ORM\EntityManagerInterface;

class TableSelector
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function selectTable(int $revenges, int $numberOfGames): array
    {
        $duelTable = [];

        $dTable = $this->em->getRepository('App:ShuffledPairs')->findNotPlayedDuels();
        $rTable = $this->em->getRepository('App:ShuffledPairs')->findNotPlayedRevenges();

        if (0 === $revenges && empty($dTable) && 1 === $numberOfGames || 1 === $revenges && empty($rTable)) {
            $duelTable = ['end'];
        } elseif (1 === $revenges && empty($dTable)) {
            $duelTable = ['revenges', $rTable];
        } else {
            $duelTable = ['duels', $dTable];
        }

        return $duelTable;
    }
}
