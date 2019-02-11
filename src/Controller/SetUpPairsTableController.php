<?php

declare(strict_types=1);

namespace App\Controller;

use App\Helpers\RemoveDataFromTables;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Helpers\PrepareTables;

class SetUpPairsTableController extends AbstractController
{
    /**
     * @Route("/pairs-table-setup", name="pairs_table_setup")
     *
     * @param PrepareTables        $prepare
     * @param RemoveDataFromTables $remove
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function PreparePairTable(PrepareTables $prepare, RemoveDataFromTables $remove)
    {
        $remove->deletePairsTable();
        $prepare->setPairsTable();

        return $this->redirectToRoute('render_table');
    }
}
