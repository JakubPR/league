<?php

namespace App\Controller;

use App\Builder\ConfigurationSettings;
use App\Builder\ScoreTableBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Builder\SessionManager;


class StartGameController extends AbstractController
{
    /**
     * @Route("/start", name="start-game")
     */
    public function index(ScoreTableBuilder $builder, SessionManager $sessionManager, ConfigurationSettings $configuration)
    {
//        $tableStatus = 'NOPE';
        $sessionManager->setShuffledNo();

        if ($configuration->getStatusState('numberOfGames') === 0) {
            $builder->buildTable();
        }

//        if (!$builder->checkIfTableHasBeenCreatedToday()) {
//            $builder->buildTable();
//
//            $tableStatus = 'Done!';
//        }
//        return $this->redirectToRoute('render_table', ['tableStatus' => $tableStatus]);
        return $this->redirectToRoute('render_table');
    }
}
