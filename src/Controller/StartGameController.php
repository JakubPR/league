<?php

namespace App\Controller;

use App\Builder\ScoreTableBuilder;
use App\Builder\StatusTable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Builder\SessionManager;


class StartGameController extends AbstractController
{
    /**
     * @Route("/start", name="start-game")
     */
    public function index(ScoreTableBuilder $builder, SessionManager $sessionManager, StatusTable $statusTable)
    {
        $tableStatus = 'NOPE';
        $sessionManager->setShuffledNo();

        $statusTable->buildStatusTable();

        if (!$builder->checkIfTableHasBeenCreatedToday()) {
            $builder->buildTable();

            $tableStatus = 'Done!';
        }

        return $this->redirectToRoute('render_table', ['tableStatus' => $tableStatus]);
    }
}
