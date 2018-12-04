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
        $tableStatus = 'NOPE';

        if (!$builder->checkIfTableHasBeenCreatedToday()) {
            $builder->buildTable();
            $tableStatus = 'Done!';
        }

//        return $this->render('render_table/index.html.twig', ['tableStatus' => $tableStatus]);
        return $this->redirectToRoute('render_table', ['tableStatus' => $tableStatus]);
    }
}
