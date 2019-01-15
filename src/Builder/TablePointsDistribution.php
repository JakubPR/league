<?php

namespace App\Builder;

use App\Entity\ScoreTable;
use App\Entity\ShuffledPairs;
use Doctrine\ORM\EntityManagerInterface;

class TablePointsDistribution
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function updateScoreTable($request)
    {
        dump($request);
        $repo = $this->em->getRepository(ShuffledPairs::class)->findAll();
        dump($repo);
        foreach ($request as $id => $score) {
        }
        // TODO: Search for pair
    }
}