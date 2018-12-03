<?php

namespace App\Controller;

use App\Builder\ScoreTableBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StartGameController extends AbstractController
{
    /**
     * @Route("/start", name="start-game")
     */
    public function index(ScoreTableBuilder $builder)
    {
        $builder->buildTable();
    }
}
