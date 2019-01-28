<?php

namespace App\Controller;

use App\Builder\TablePointsDistribution;
use App\Builder\SettingsTableBuilder;
use App\Builder\SessionManager;
use App\Builder\ScoreTableBuilder;
use App\Repository\ScoreTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route as Route;
use App\Builder\PairsTableBuilder;

class RenderTableController extends AbstractController
{
    private $repo;
    private $sessionManager;
    private $tableBuilder;
    private $em;
    private $pairsTable;
    private $distribution;

    public function __construct(
        TablePointsDistribution $distribution,
        ScoreTableRepository $repo,
        SessionManager $sessionManager,
        ScoreTableBuilder $tableBuilder,
        EntityManagerInterface $em,
        PairsTableBuilder $pairsTable
    ) {
        $this->distribution = $distribution;
        $this->repo = $repo;
        $this->sessionManager = $sessionManager;
        $this->tableBuilder = $tableBuilder;
        $this->em = $em;
        $this->pairsTable = $pairsTable;
    }

    /**
     * @Route("/render/table", name="render_table")
     */
    public function index(SettingsTableBuilder $settingsTable, PairsTableBuilder $pairsTable, ScoreTableBuilder $scoreTable)
    {
        $numberOfGames = $settingsTable->getStatusState(SettingsTableBuilder::NUMBER_OF_GAMES);
        $tableData = $scoreTable->getTableDataForCurrentGame();

        if (0 != $settingsTable->getStatusState(SettingsTableBuilder::NUMBER_OF_GAMES)) {
            $pairs = $pairsTable->getPairWithoutDuel();
            $duel = $pairsTable->getPairWithoutDuel();

            return $this->render(
                'render_table/index.html.twig', [
                'numberOfGames' => $numberOfGames,
                'tableData' => $tableData,
                'pairs' => $pairs,
                'duel' => $duel,
                ]
            );
        }

        return $this->render(
            'render_table/endgame.html.twig', [
            'tableData' => $tableData,
            ]
        );
    }

    /**
     * @Route("/render/getscore", name="get_score")
     **/
    public function getScore(Request $request)
    {
        $this->distribution->updateScoreTable($request->request->all());
        // return $this->redirectToRoute('render_table');
    }
}
