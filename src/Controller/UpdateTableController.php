<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route as Route;
use Doctrine\ORM\EntityManagerInterface;

class UpdateTableController
{
    /**
     * @Route("/render/table/update/{scores}", name="update_table")
     *
     * @param string $scores
     */
    public function updateTable(string $scores, EntityManagerInterface $em)
    {
        dump(json_decode($scores));

    }
}
