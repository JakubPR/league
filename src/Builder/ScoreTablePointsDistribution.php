<?php

namespace App\Builder;

use App\Entity\ShuffledPairs;
use Doctrine\ORM\EntityManagerInterface;

class ScoreTablePointsDistribution
{
    private $em;

    private function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function updateScoreTable($request)
    {
        foreach ($request as $id => $score) {
            $player = $this->em->getRepository(ShuffledPairs::class)->findOneBy(['Player1' => $id]);
            dump($player);
        }
    }
}