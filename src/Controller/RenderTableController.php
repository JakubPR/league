<?php

namespace App\Controller;

use App\Entity\Settings;
use App\Service\SettingsManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Helpers\DataValidator;

class RenderTableController extends AbstractController
{
    private $em;
    private $dv;

    public function __construct(
        EntityManagerInterface $em,
        DataValidator $dv
    ) {
        $this->em = $em;
        $this->dv = $dv;
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

    /**
     * @Route("/render/score/check", name="check_score")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function checkScore(Request $request)
    {
        $scores = $request->request->all();
        foreach ($scores as $score) {
            if ($this->dv->validateScore($score)) {
                $this->addFlash('notice', $this->dv->validateScore($score));

                return $this->redirectToRoute('render_table');
            }
        }

        return $this->redirectToRoute('update_table', [
            'scores' => json_encode($scores),
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
