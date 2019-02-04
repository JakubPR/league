<?php

declare(strict_types=1);

namespace App\Helpers;

use Doctrine\ORM\EntityManagerInterface;

class PrepareTables
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function setData()
    {

    }
}
