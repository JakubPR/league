<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Helpers\RemoveDataFromTables;

class CleanUpAndPrepareTablesController extends AbstractController
{
    /**
     * @Route("/cleanandprepare", name="clean_and_prepare")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     *   * @param RemoveDataFromTables $remove
     */
    public function cleanAndPrepareTables(RemoveDataFromTables $remove)
    {
        $remove->removeData();

        return $this->redirectToRoute('select_players');
    }
}
