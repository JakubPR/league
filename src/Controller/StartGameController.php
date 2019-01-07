<?php

namespace App\Controller;

use App\Builder\ConfigurationSettings;
use App\Builder\PairsTableBuilder;
use App\Builder\ScoreTableBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Builder\SessionManager;


class StartGameController extends AbstractController
{
    /**
     * @Route("/start", name="start-game")
     */
    public function index(ScoreTableBuilder $scoreTableBuilder, PairsTableBuilder $pairsTableBuilder, ConfigurationSettings $configuration)
    {
        if ($configuration->getStatusState('numberOfGames') === 0) {
            $scoreTableBuilder->buildTable();
            $pairsTableBuilder->preparePairsTable();
        }
        return $this->redirectToRoute('render_table');
    }
}
