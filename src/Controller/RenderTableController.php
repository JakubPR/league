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

    public function __construct(ScoreTableRepository $repo, SessionManager $sessionManager)
    {
        $this->repo = $repo;
        $this->sessionManager = $sessionManager;
    }

    /**
     * @Route("/render/table", name="render_table")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, ScoreTableBuilder $tableBuilder, SessionManager $sessionManager)
    {
        $tableStatus = $request->get('tableStatus');
        $tableData = $this->getTableDataForCurrentGame($tableBuilder->getLastAddedGameId());
        $this->shuffleOnce($tableData);

        dump($sessionManager->getShuffledData());

        return $this->render('render_table/index.html.twig', [
            'tableStatus' => $tableStatus,
            'tableData' => $tableData,
            'shuffleData' => $sessionManager->getShuffledData()
        ]);
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
