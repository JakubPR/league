<?php

namespace App\Controller;

use App\Builder\ScoreTableBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StartGameController extends AbstractController
{
    private $table;

    public function __construct(ScoreTableBuilder $table)
    {
        $this->table = $table;
    }
    /**
     * @Route("/start", name="start-game")
     */
    public function index()
    {
        $this->table->setDate();
        $this->table->addPlayers();

        return $this->render('game/game.html.twig', ['table' => $this->table->saveObject()]);
    }

}
