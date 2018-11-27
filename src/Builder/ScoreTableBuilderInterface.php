<?php

namespace App\Builder;

interface ScoreTableBuilderInterface
{
    public function setDate();
    public function addPlayers();
    public function getResult();
}