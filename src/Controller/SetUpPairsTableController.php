<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Helpers\PrepareTables;

class SetUpPairsTableController extends AbstractController
{
    /**
     * @Route("/pairs-table-setup", name="pairs_table_setup")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @param PrepareTables $prepare
     */
    public function PrepareTables(PrepareTables $prepare)
    {
        $prepare->setPairsTable();

        return $this->redirectToRoute('render_table');
    }
}
