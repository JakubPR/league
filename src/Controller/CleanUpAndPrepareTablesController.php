<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CleanUpAndPrepareTablesController extends AbstractController
{
    /**
     * @Route("/cleanandprepare", name="clean_and_prepare")
     */
    public function cleanAndPrepareTables()
    {

        return $this->redirectToRoute('select_players');
    }
}
