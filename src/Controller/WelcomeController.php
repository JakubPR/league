<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Builder\ConfigurationSettings;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index(ConfigurationSettings $statusTableBuilder)
    {
        $statusTableBuilder->buildStatusTable();
        return $this->render('welcome/welcome.html.twig');
    }
}
