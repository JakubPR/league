<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RenderTableController extends AbstractController
{
    /**
     * @Route("/render/table", name="render_table")
     * @param $tableId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index($tableId)
    {
        return $this->render('render_table/index.html.twig', [
            'tableId' => $tableId,
        ]);
    }
}
