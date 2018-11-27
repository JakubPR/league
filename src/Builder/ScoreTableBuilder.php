<?php

namespace App\Builder;

use App\Entity\ScoreTable;
use DateTime;

class ScoreTableBuilder implements ScoreTableBuilderInterface
{
    private $table;

    public function __construct()
    {
        $this->table = new ScoreTable();
    }

    public function setDate()
    {
        $currentDateTime = new DateTime('now');
        $this->table->setDate($currentDateTime);
    }

    public function addPlayers()
    {
        $this->table->setPlayers(['player']);
    }

    public function getResult()
    {
        return $this->table;
    }
}