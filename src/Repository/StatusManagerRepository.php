<?php

namespace App\Repository;

use App\Entity\StatusManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StatusManager|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatusManager|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatusManager[]    findAll()
 * @method StatusManager[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusManagerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StatusManager::class);
    }
}
