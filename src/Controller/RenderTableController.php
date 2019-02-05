<?php

namespace App\Controller;

use App\Entity\Settings;
use App\Service\SettingsManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RenderTableController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/render", name="render_table")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @param SettingsManager $setMan
     */
    public function renderTable(SettingsManager $setMan)
    {
        $numberOfGames = $setMan->getSettingValue(Settings::$NUMBER_OF_GAMES);
        $revenges = $setMan->getSettingValue(Settings::$REVENGES);
        $scoreTable = $this->em->getRepository('App:ScoreTable')->findAll();
        $duels = $this->em->getRepository('App:ShuffledPairs')->findAll();

        return $this->render('render_table/render_table.html.twig', [
            'numberOfGames' => $numberOfGames,
            'revenges' => $this->changeToStr($revenges),
            'scoreTable' => $scoreTable,
            'duels' => $duels,
        ]);
    }

    private function changeToStr(int $int): string
    {
        if (1 === $int) {
            return 'on';
        }

        return 'off';
    }
}
