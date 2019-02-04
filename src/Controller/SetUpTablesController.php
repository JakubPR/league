<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Helpers\PrepareTables;

class SetUpTablesController extends AbstractController
{
    /**
     * @Route("/datasetup", name="data_setup")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @param PrepareTables $prepare
     */
    public function PrepareTables(PrepareTables $prepare)
    {
        $prepare->setData();

        return $this->redirectToRoute('settings');
    }
}
