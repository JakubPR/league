<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route as Route;

class RenderTableController extends AbstractController
{
    /**
     * @Route("/render/table", name="render_table")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {

        $tableStatus = $request->get('tableStatus');

        return $this->render('render_table/index.html.twig', [
            'tableStatus' => $tableStatus
        ]);
    }

}
