<?php

declare(strict_types=1);

namespace App\Helpers;

use Doctrine\ORM\EntityManagerInterface;

class RemoveDataFromTables
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function removeData()
    {
        $this->deletePairTable();
        $this->remove($this->em->getRepository('App:ShuffledPairs')->findAll());
    }

    public function deletePairTable()
    {
        $this->remove($this->em->getRepository('App:ScoreTable')->findAll());
    }

    private function remove(array $toRemove)
    {
        foreach ($toRemove as $record) {
            $this->em->remove($record);
            $this->em->flush();
        }
    }
}
