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
        $dTable = $this->em->getRepository('App:ShuffledPairs')->findNotPlayedDuels();
        $rTable = $this->em->getRepository('App:ShuffledPairs')->findNotPlayedRevenges();

        if (0 === $numberOfGames) {
            $duelTable = ['end'];
        } elseif (1 === $revenges && empty($dTable)) {
            $duelTable = ['revenges', $rTable];
        } else {
            $duelTable = ['duels', $dTable];
        }

        return $duelTable;
    }
}
