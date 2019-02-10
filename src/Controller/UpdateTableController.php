<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route as Route;
use App\Helpers\UpdateTables;

class UpdateTableController extends AbstractController
{
    /**
     * @Route("/render/table/update/{scores}/{selector}/{duelId}", name="update_table")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @param string       $scores
     * @param string       $selector
     * @param string       $duelId
     * @param UpdateTables $update
     */
    public function updateTable(
        string $scores,
        string $selector,
        string $duelId,
        UpdateTables $update
    ) {
        $update->updatePairsTable(json_decode($selector, true), json_decode($duelId, true));
        $update->updateScoreTable(json_decode($scores, true));

        return $this->redirectToRoute('render_table');
    }
}
