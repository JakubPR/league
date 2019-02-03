<?php

namespace App\Controller;

use App\Builder\SettingsTableBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route as Route;

class NumberOfGamesController extends AbstractController
{
    /**
     * @Route("/numberofgames", name="games_number")
     */
    public function showNumberOfGames()
    {
        return $this->render('number_of_games/numberofgames.html.twig');
    }

    /**
     * @Route("/numberofgames/getnumber", name="get_number")
     **/
    public function saveNumberOfGames(Request $request, SettingsTableBuilder $settingsTable)
    {
        $settingsTable->changeStatusState(SettingsTableBuilder::NUMBER_OF_GAMES, $request->get('number'));

        return $this->redirectToRoute('games_number');
    }
}
