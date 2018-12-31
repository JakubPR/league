<?php
namespace App\Controller;

use App\Builder\StatusTableBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route as Route;

class NumberOfGamesController extends AbstractController
{
    /**
     * @Route("/numberofgames", name="games-number")
     */
    function show()
    {
        return $this->render('number of games/index.html.twig');
    }

    /**
     * @Route("/numberofgames/getnumber", name="get_number")
     **/
    function saveNumberOfGames(Request $request, StatusTableBuilder $statusTable)
    {
        $statusTable->changeStatus('numberOfGames',$request->get('number'));
        return $this->redirectToRoute('welcome');
    }
}