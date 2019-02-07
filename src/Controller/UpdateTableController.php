<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route as Route;
use App\Helpers\Calculate;

class UpdateTableController
{
    /**
     * @Route("/render/table/update/{scores}", name="update_table")
     *
     * @param string    $scores
     * @param Calculate $calc
     */
    public function updateTable(
        string $scores,
        Calculate $calc
    ) {
        $calc->calculatePoints(json_decode($scores, true));
    }
}
