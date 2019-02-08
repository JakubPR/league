<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route as Route;
use App\Helpers\Calculate;

class UpdateTableController extends AbstractController
{
    /**
     * @Route("/render/table/update/{scores}", name="update_table")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @param string    $scores
     * @param Calculate $calc
     */
    public function updateTable(
        string $scores,
        Calculate $calc
    ) {
        $calc->calculatePoints(json_decode($scores, true));

        //return $this->redirectToRoute('render_table');
    }
}
