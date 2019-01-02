<?php

namespace App\Repository;

use App\Entity\ShuffledPairs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ShuffledPairs|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShuffledPairs|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShuffledPairs[]    findAll()
 * @method ShuffledPairs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShuffledPairsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ShuffledPairs::class);
    }

    // /**
    //  * @return ShuffledPairs[] Returns an array of ShuffledPairs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShuffledPairs
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
