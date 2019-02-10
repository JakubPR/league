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

    public function findNotPlayedDuels()
    {
        return $this->createQueryBuilder('td')
            ->where('td.duel != 1')
            ->getQuery()
            ->getResult();
    }

    public function findNotPlayedRevenges()
    {
        return $this->createQueryBuilder('td')
            ->where('td.revenge != 1')
            ->getQuery()
            ->getResult();
    }
}
