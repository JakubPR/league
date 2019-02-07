<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Settings;
use App\Service\SettingsManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\DataValidator;
use App\Service\DataTypeConverter;

class RenderTableController extends AbstractController
{
    private $em;
    private $dv;
    private $con;

    public function __construct(
        EntityManagerInterface $em,
        DataValidator $dv,
        DataTypeConverter $con
    ) {
        $this->em = $em;
        $this->dv = $dv;
        $this->con = $con;
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

        return $this->render(
            'render_table/render_table.html.twig', [
            'numberOfGames' => $numberOfGames,
            'revenges' => $this->con->changeToStr($revenges),
            'scoreTable' => $scoreTable,
            'duels' => $duels,
            ]
        );
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

        return $this->redirectToRoute(
            'update_table', [
            'scores' => json_encode($scores),
            ]
        );
    }
}
