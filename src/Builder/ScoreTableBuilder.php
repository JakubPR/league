<?php

namespace App\Builder;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ScoreTable;
use DateTime;

class ScoreTableBuilder implements ScoreTableBuilderInterface
{
    private $table;
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->table = new ScoreTable();
        $this->em = $em;
    }

    public function setDate()
    {
        $currentDateTime = new DateTime('now');
        $this->table->setDate($currentDateTime);
    }

    public function addPlayers()
    {
        $players = $this->em->getRepository('App:Player')->findAll();

        $this->table->setPlayers($players);
    }

    public function saveObject()
    {
        return $this->table;
    }
}