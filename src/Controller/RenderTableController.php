<?php

namespace App\Controller;

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
    public function index(Request $request, SessionManager $sessionManager, SettingsTableBuilder $settingsTable)
    {
        $numberOfGames = $settingsTable->getStatusState(SettingsTableBuilder::NUMBER_OF_GAMES);
        $tableStatus = $request->get('tableStatus');
        $tableData = $this->getTableDataForCurrentGame($this->tableBuilder->getLastAddedGameId());
        $this->shuffleOnce($tableData);

        if (!empty($sessionManager->getShuffledData())) {
            $pair = $sessionManager->getShuffledData()[0];

            return $this->render('render_table/index.html.twig', [
                'tableStatus' => $tableStatus,
                'numberOfGames' => $numberOfGames,
                'tableData' => $tableData,
                'shuffleData' => $sessionManager->getShuffledData(),
                'pair' => $pair
            ]);
        }

        return $this->render('render_table/endgame.html.twig', [
            'tableStatus' => $tableStatus,
            'tableData' => $tableData
        ]);
    }

    /**
     * @Route("/render/getscore", name="get_score")
     **/
    public function getScore(Request $request)
    {
        $results = $request->request->all();

        $i = 1;
        foreach ($results as $id => $points)
        {
            ${"player$i"} = ['id' => $id, 'points' => $points];
            $i++;
        }

        $this->setTablePoints($player1, $player2);

        return $this->redirectToRoute('render_table');
    }

    public function setTablePoints($player1, $player2)
    {
        if ($player1['points'] > $player2['points']) {
            $player1 += ['table_points' => 2];
            $player2 += ['table_points' => 0];
        } elseif ($player1['points'] < $player2['points']) {
            $player1 += ['table_points' => 0];
            $player2 += ['table_points' => 2];
        } else {
            $player1 += ['table_points' => 1];
            $player2 += ['table_points' => 1];
        }

        $this->addPointsToTable($player1, $player2);
    }

    function addPointsToTable($player1, $player2)
    {
        $tableData = $this->getTableDataForCurrentGame($this->tableBuilder->getLastAddedGameId());

        foreach ($tableData as $row) {
            /** @var $row \App\Entity\ScoreTable **/
            if ($row->getId() === $player1['id'])
            {
                $row->setPoints($row->getPoints() + $player1['table_points']);
                $this->saveNewData($row);
            } elseif ($row->getId() === $player2['id']) {
                $row->setPoints($row->getPoints() + $player2['table_points']);
                $this->saveNewData($row);
            }
        }

        $pairs = $this->sessionManager->getShuffledData();
        if (!empty($pairs)) {
            array_shift($pairs);
            $this->sessionManager->setShuffledData($pairs);
        } else {
            $end = "End of the game";
            dump($end);
        }
    }

    public function saveNewData($row)
    {
        /** @var $row ScoreTable */
        $this->em->persist($row);
        $this->em->flush();
    }

    public function shuffleOnce($tableData)
    {
        if (!$this->sessionManager->checkShuffle()) {
            $shuffledData = $tableData;
            shuffle($shuffledData);
            $shuffledData = array_chunk($shuffledData,2);
            $this->sessionManager->setShuffledData($shuffledData);
            $this->sessionManager->setShuffledYes();
        }
    }

    public function getTableDataForCurrentGame($tableId)
    {
       return $this->repo->findAllCurrentData($tableId);
    }
}
