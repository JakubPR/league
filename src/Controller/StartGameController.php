<?php

namespace App\Controller;

use App\Builder\SettingsTableBuilder;
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
    public function index(ScoreTableBuilder $scoreTableBuilder, PairsTableBuilder $pairsTableBuilder, SettingsTableBuilder $settingsTable)
    {
        if ($settingsTable->getStatusState(SettingsTableBuilder::NUMBER_OF_GAMES) === 0) {
            $scoreTableBuilder->buildTable();
            $pairsTableBuilder->preparePairsTable();
        }
        return $this->redirectToRoute('render_table');
    }
}
