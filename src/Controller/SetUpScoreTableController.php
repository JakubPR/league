<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Helpers\PrepareTables;

class SetUpScoreTableController extends AbstractController
{
    /**
     * @Route("/score-table-setup", name="score_table_setup")
     *
     * @param PrepareTables $prepare
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function PrepareTables(PrepareTables $prepare)
    {
        $prepare->setScoreTable();
        $prepare->setSettingsTable();

        return $this->redirectToRoute('settings');
    }
}
