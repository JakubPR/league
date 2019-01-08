<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Builder\SettingsTableBuilder;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index(SettingsTableBuilder $settingsTable)
    {
        $settingsTable->buildStatusTable();
        return $this->render('welcome/welcome.html.twig');
    }
}
