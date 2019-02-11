<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Helpers\RemoveDataFromTables;

class CleanUpTablesController extends AbstractController
{
    /**
     * @Route("/dataremove", name="data_remove")
     *
     * @param RemoveDataFromTables $remove
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function cleanAndPrepareTables(RemoveDataFromTables $remove)
    {
        $remove->removeData();

        return $this->redirectToRoute('select_players');
    }
}
