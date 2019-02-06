<?php

namespace App\Repository;

use App\Entity\ShuffledPairs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ShuffledPairsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ShuffledPairs::class);
    }

    public function findPairById(int $pairId)
    {
        return $this->createQueryBuilder('td')
            ->where('td.gameId ='.$pairId)
            ->orderBy('td.points', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
