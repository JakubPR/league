<?php

namespace App\Repository;

use App\Entity\ScoreTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ScoreTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScoreTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScoreTable[]    findAll()
 * @method ScoreTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
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

    public function findOneBySomeField($value): ?ScoreTable
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
        ;
    }

}
