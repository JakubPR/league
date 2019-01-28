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

    public function findPairById(int $pairId)
    {
        return $this->createQueryBuilder('td')
            ->where('td.gameId ='.$pairId)
            ->orderBy('td.points', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
