<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StartGameController extends AbstractController
{
    /**
     * @Route("/start", name="start-game")
     */
    public function index()
    {
        return $this->redirectToRoute('render_table');
    }
}
