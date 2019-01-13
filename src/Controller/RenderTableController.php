<?php

namespace App\Controller;

use App\Builder\ScoreTablePointsDistribution;
use App\Builder\SettingsTableBuilder;
use App\Builder\SessionManager;
use App\Builder\ScoreTableBuilder;
use App\Entity\ScoreTable;
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

    public function __construct
    (
        ScoreTableRepository $repo,
        SessionManager $sessionManager,
        ScoreTableBuilder $tableBuilder,
        EntityManagerInterface $em,
        PairsTableBuilder $pairsTable

    ){
        $this->repo = $repo;
        $this->sessionManager = $sessionManager;
        $this->tableBuilder = $tableBuilder;
        $this->em = $em;
        $this->pairsTable = $pairsTable;
    }

    /**
     * @Route("/render/table", name="render_table")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(SessionManager $sessionManager, SettingsTableBuilder $settingsTable, PairsTableBuilder $pairsTable, ScoreTableBuilder $scoreTable)
    {
        $numberOfGames = $settingsTable->getStatusState(SettingsTableBuilder::NUMBER_OF_GAMES);
        $tableData = $this->getTableDataForCurrentGame($scoreTable->getLastAddedGameId());

        if ($settingsTable->getStatusState(SettingsTableBuilder::NUMBER_OF_GAMES) != 0) {
            $pairs = $pairsTable->getDataFromPairsTable();
            $duel = $pairsTable->getPairWithoutDuel();

            return $this->render('render_table/index.html.twig', [
                'numberOfGames' => $numberOfGames,
                'tableData' => $tableData,
                'pairs' => $pairs,
                'duel' => $duel
            ]);
        }

        return $this->render('render_table/endgame.html.twig', [
            'tableData' => $tableData
        ]);
    }

    /**
     * @Route("/render/getscore", name="get_score")
     **/
    public function getScore(Request $request, ScoreTablePointsDistribution $distributor)
    {
        $distributor->updateScoreTable($request->request->all());
        return $this->redirectToRoute('render_table');
    }
}
