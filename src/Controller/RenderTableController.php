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
use App\Helpers\TableSelector;

class RenderTableController extends AbstractController
{
    private $em;
    private $dv;
    private $con;
    private $selector;

    public function __construct(
        EntityManagerInterface $em,
        DataValidator $dv,
        DataTypeConverter $con,
        TableSelector $selector
    ) {
        $this->em = $em;
        $this->dv = $dv;
        $this->con = $con;
        $this->selector = $selector;
    }

    /**
     * @Route("/render", name="render_table")
     *
     * @param SettingsManager $setMan
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderTable(
        SettingsManager $setMan
    ) {
        $numberOfGames = $setMan->getSettingValue(Settings::$NUMBER_OF_GAMES);
        $revenges = $setMan->getSettingValue(Settings::$REVENGES);
        $scoreTable = $this->em->getRepository('App:ScoreTable')->findAll();

        $duelTable = $this->selector->selectTable($revenges, $numberOfGames);

        if (('end' === $duelTable[0]) && 0 === $numberOfGames) {
            return $this->render(
                'render_table/end_table.html.twig', [
                    'scoreTable' => $scoreTable,
                ]
            );
        } elseif ('duels' === $duelTable[0] && empty($duelTable[1])) {
            $setMan->changeSettings(Settings::$NUMBER_OF_GAMES, $numberOfGames - 1);

        }

        $selector = $duelTable[0];

        return $this->render(
            'render_table/render_table.html.twig', [
            'numberOfGames' => $numberOfGames,
            'revenges' => $this->con->changeToStr($revenges),
            'scoreTable' => $scoreTable,
            'duelTable' => $duelTable[1],
            'selector' => $selector,
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
        $duelId = $scores['duelId'];
        $selector = $scores['selector'];
        array_pop($scores);
        array_pop($scores);

        foreach ($scores as $score) {
            if ($this->dv->validateScore($score)) {
                $this->addFlash('notice', $this->dv->validateScore($score));

                return $this->redirectToRoute('render_table');
            }
        }

        return $this->redirectToRoute(
            'update_table', [
                'scores' => json_encode($scores),
                'selector' => json_encode($selector),
                'duelId' => json_encode($duelId),
            ]
        );
    }
}
