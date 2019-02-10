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

    public function findAllAndSort()
    {
        return $this->createQueryBuilder('sc')
            ->add('orderBy', 'sc.points DESC, sc.score DESC')
            ->getQuery()
            ->getResult();
    }
}
