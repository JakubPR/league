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
    private $con;
    private $selector;

    public function __construct(
        DataTypeConverter $con,
        TableSelector $selector
    ) {
        $this->con = $con;
        $this->selector = $selector;
    }

    /**
     * @Route("/render", name="render_table")
     *
     * @param SettingsManager        $setMan
     * @param EntityManagerInterface $em
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderTable(
        SettingsManager $setMan,
        EntityManagerInterface $em
    ) {
        $numberOfGames = $setMan->getSettingValue(Settings::$NUMBER_OF_GAMES);
        $revenges = $setMan->getSettingValue(Settings::$REVENGES);
        $scoreTable = $em->getRepository('App:ScoreTable')->findAllAndSort();

        $duelTable = $this->selector->selectTable($revenges, $numberOfGames);

        if (('end' === $duelTable[0]) && $numberOfGames <= 1) {
            return $this->render(
                'render_table/end_table.html.twig', [
                    'scoreTable' => $scoreTable,
                ]
            );
        } elseif ('duels' === $duelTable[0] && empty($duelTable[1]) || 'revenges' === $duelTable[0] && empty($duelTable[1])) {
            $setMan->changeSettings(Settings::$NUMBER_OF_GAMES, $numberOfGames - 1);

            return $this->redirectToRoute('pairs_table_setup');
        }
        $selector = $duelTable[0];
        //dump($duelTable);
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
     * @Route("/render/score/get", name="get_score")
     *
     * @param Request       $request
     * @param DataValidator $validator
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getScore(Request $request, DataValidator $validator)
    {
        $scores = $request->request->all();
        $duelId = $scores['duelId'];
        $selector = $scores['selector'];
        array_pop($scores);
        array_pop($scores);

        foreach ($scores as $score) {
            if (!$validator->validateScore($score)) {
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
