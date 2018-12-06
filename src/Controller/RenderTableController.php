<?php

namespace App\Controller;

use App\Builder\ScoreTableBuilder;
use App\Repository\ScoreTableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route as Route;

class RenderTableController extends AbstractController
{
    private $repo;

    public function __construct(ScoreTableRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/render/table", name="render_table")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, ScoreTableBuilder $tableBuilder)
    {
        $tableStatus = $request->get('tableStatus');
        $tableId = $tableBuilder->getLastAddedGameId();
        $tableData = $this->getTableDataForCurrentGame($tableId);

        return $this->render('render_table/index.html.twig', [
            'tableStatus' => $tableStatus,
            'tableId' => $tableId,
            'tableData' => $tableData
        ]);
    }

    public function getTableDataForCurrentGame($tableId)
    {
       return $this->repo->findAllCurrentData($tableId);
    }
}
