<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route as Route;

class UpdateTableController
{
    /**
     * @Route("/render/table/update/{scores}", name="update_table")
     * @param string $scores
     */
    public function updateTable(string $scores)
    {
        dump(json_decode($scores));
    }
}
