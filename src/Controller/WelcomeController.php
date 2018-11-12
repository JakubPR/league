<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index()
    {
        return $this->render('welcome/welcome.html.twig');
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/WelcomeController.php',
//        ]);
    }
}
