<?php

namespace App\Repository;

use App\Entity\ScoreTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ScoreTableRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ScoreTable::class);
    }

    public function findLastAddedId()
    {
        return $this->createQueryBuilder('st')
            ->orderBy('st.gameId', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

    public function findAllCurrentData($tableId)
    {
        return $this->createQueryBuilder('td')
            ->where('td.gameId ='.$tableId)
            ->orderBy('td.points', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
