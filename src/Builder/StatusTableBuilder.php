<?php

namespace App\Builder;

use App\Entity\StatusManager;
use Doctrine\ORM\EntityManagerInterface;

class StatusTableBuilder
{
    public static $statuses = [
        'createNewGame' => 0,
        'shuffledTable' => 0,
        'numberOfGames' => 0,
    ];

    public $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildStatusTable()
    {
        if (empty($this->em->getRepository('App:StatusManager')->findAll()))
        {
            foreach (StatusTableBuilder::$statuses as $name => $value) {
                $status = new StatusManager();
                $status->setName($name);
                $status->setStatus($value);
                $this->em->persist($status);
            }
            $this->em->flush();
        }
    }

    public function changeStatus(string $statusName, int $statusVariable)
    {
        $statusToChange = $this->getStatusByName($statusName);
        $statusToChange->setStatus($statusVariable);

        $this->em->persist($statusToChange);
        $this->em->flush();
    }

    public function getStatusState(string $statusName)
    {
       $status =  $this->getStatusByName($statusName);
       return $status->getStatus();
    }

    public function getStatusByName(string $statusName) : StatusManager
    {
        return $this->em->getRepository('App:StatusManager')->findOneBy(['name' => $statusName]);
    }
}