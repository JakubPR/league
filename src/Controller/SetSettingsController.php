<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Service\SettingsManager;
use Symfony\Component\Routing\Annotation\Route as Route;

class SetSettingsController extends AbstractController
{
    /**
     * @Route("/settings", name="games_number")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @param SettingsManager $setMan
     */
    public function showNumberOfGames(SettingsManager $setMan)
    {
        return $this->render(
            'set_settings/setsettings.html.twig',
            [
                'numberOfGames' => $setMan->getSettingValue(
                    SettingsManager::$NUMBER_OF_GAMES
                ),
                'revenges' => $setMan->getSettingValue(
                    SettingsManager::$REVENGES
                ),
            ]
        );
    }

    /**
     * @Route("/settings/getnumber", name="get_number")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @param Request         $request
     * @param SettingsManager $setMan
     */
    public function saveNumberOfGamesSetting(
        Request $request,
        SettingsManager $setMan
    ) {
        $setMan->changeSettings(
            SettingsManager::$NUMBER_OF_GAMES,
            $request->request->getInt('number')
        );

        return $this->redirectToRoute('games_number');
    }

    /**
     * @Route("/settings/getanswer", name="get_answer")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @param Request         $request
     * @param SettingsManager $setMan
     */
    public function saveRevengeSetting(Request $request, SettingsManager $setMan)
    {
        $setMan->changeSettings(
            SettingsManager::$REVENGES,
            $this->changeToInt($request->get('answer'))
        );

        return $this->redirectToRoute('games_number');
    }

    private function changeToInt(string $str): int
    {
        if ('yes' === $str) {
            return 1;
        }

        return 0;
    }
}
