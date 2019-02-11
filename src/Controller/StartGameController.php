<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StartGameController extends AbstractController
{
    /**
     * @Route("/start", name="start_game")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function index()
    {
        return $this->redirectToRoute('render_table');
    }
}
