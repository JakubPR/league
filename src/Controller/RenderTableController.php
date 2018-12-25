<?php

namespace App\Controller;

use App\Builder\SessionManager;
use App\Builder\ScoreTableBuilder;
use App\Repository\ScoreTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route as Route;

class RenderTableController extends AbstractController
{
    private $repo;
    private $sessionManager;
    private $tableBuilder;

    public function __construct(ScoreTableRepository $repo, SessionManager $sessionManager, ScoreTableBuilder $tableBuilder)
    {
        $this->repo = $repo;
        $this->sessionManager = $sessionManager;
        $this->tableBuilder = $tableBuilder;
    }

    /**
     * @Route("/render/table", name="render_table")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, SessionManager $sessionManager)
    {
        $tableStatus = $request->get('tableStatus');
        $tableData = $this->getTableDataForCurrentGame($this->tableBuilder->getLastAddedGameId());
        $this->shuffleOnce($tableData);

        // $pairsCount = count($sessionManager->getShuffledData());
        $pair = $sessionManager->getShuffledData()[0];

        return $this->render('render_table/index.html.twig', [
            'tableStatus' => $tableStatus,
            'tableData' => $tableData,
            'shuffleData' => $sessionManager->getShuffledData(),
            'pair' => $pair
        ]);
    }

    /**
     * @Route("/render/getscore", name="get_score")
     **/
    public function getScore(Request $request)
    {
        $results = $request->request->all();

        $i = 1;
        foreach ($results as $id => $score)
        {
            ${"player$i"} = ['id' => $id, 'score' => $score];
            $i++;
        }

        $this->setTablePoints($player1, $player2);

        $test= 'test';
        dump($test);
    }

    public function setTablePoints($player1, $player2)
    {
        if ($player1['score'] > $player2['score']) {
            $player1 += ['table_points' => 2];
            $player2 += ['table_points' => -2];
        } elseif ($player1['score'] < $player2['score']) {
            $player1 += ['table_points' => -2];
            $player2 += ['table_points' => 2];
        } else {
            $player1 += ['table_points' => 1];
            $player2 += ['table_points' => 1];
        }
        dump($player1);
        dump($player2);

        $this->addPointsToTable($player1);

    }

    function addPointsToTable($player1)
    {
        $tableData = $this->getTableDataForCurrentGame($this->tableBuilder->getLastAddedGameId());
        dump($tableData);

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
