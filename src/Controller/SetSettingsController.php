<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Service\SettingsManager;
use App\Service\DataTypeConverter;
use App\Entity\Settings;
use Symfony\Component\Routing\Annotation\Route as Route;

class SetSettingsController extends AbstractController
{
    private $con;

    public function __construct(DataTypeConverter $con)
    {
        $this->con = $con;
    }

    /**
     * @Route("/settings", name="settings")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @param SettingsManager $setMan
     */
    public function showSettings(SettingsManager $setMan)
    {
        return $this->render(
            'set_settings/set_settings.html.twig',
            [
                'numberOfGames' => $setMan->getSettingValue(
                    Settings::$NUMBER_OF_GAMES
                ),
                'revenges' => $setMan->getSettingValue(
                    Settings::$REVENGES
                ),
            ]
        );
    }

    /**
     * @Route("/settings/check", name="settings_check")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @param SettingsManager $setMan
     */
    public function checkSettings(SettingsManager $setMan)
    {
        if (0 === $setMan->getSettingValue(Settings::$NUMBER_OF_GAMES)) {
            $this->addFlash('notice', 'Set number of games.');

            return $this->redirectToRoute('settings');
        }

        return $this->redirectToRoute('pairs_table_setup');
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
            Settings::$NUMBER_OF_GAMES,
            $request->request->getInt('number')
        );

        return $this->redirectToRoute('settings');
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
            Settings::$REVENGES,
            $this->con->changeToInt($request->get('answer'))
        );

        return $this->redirectToRoute('settings');
    }
}
