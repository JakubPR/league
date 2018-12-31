<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Builder\StatusTableBuilder;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index(StatusTableBuilder $statusTableBuilder)
    {
        $statusTableBuilder->buildStatusTable();
        return $this->render('welcome/welcome.html.twig');
    }
}
