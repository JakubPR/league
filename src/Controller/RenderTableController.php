<?php

namespace App\Controller;

use App\Entity\ScoreTable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ScoreTableRepository;
use Symfony\Component\Routing\Annotation\Route;

class RenderTableController extends AbstractController
{
    /**
     * @Route("/render/table", name="render_table")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, ScoreTableRepository $repo)
    {

        $tableStatus = $request->get('tableStatus');
        $scoreTable = $this->getTable($repo);

        dump($scoreTable);

        return $this->render('render_table/index.html.twig', [
            'tableStatus' => $tableStatus,
            'scoreTable' => $scoreTable
        ]);
    }

    public function getLastAddedId(ScoreTableRepository $repo)
    {
        return $repo->findLastAddedId();
        // to w kontrolerze tworzenia tabeli
    }

}
