<?php

namespace App\Controller;

use App\Repository\PlayerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormInterface;
use App\Entity\Player;
use App\Form\ManagePlayersType;

class ManagePlayersController extends AbstractController
{
    /**
     * @Route("/manage-players", name="manage-players")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
            $player = new Player();
            $addPlayerForm = $this->createForm(ManagePlayersType::class, $player);
            $playerName = $this->getFormData($request, $addPlayerForm);

            if ($playerName) {
                $this->savePlayer($playerName, $player);
            }

            return $this->render('manage players/index.html.twig', [
                'addPlayerForm' => $addPlayerForm->createView(),
                'allPlayers' => $this->getPlayers()
            ]);
    }

    public function getFormData(Request $request, FormInterface $addPlayerForm)
    {
        $addPlayerForm->handleRequest($request);

        if ($addPlayerForm->isSubmitted())
        {


            /** @var  $formData Player */
            $formData = $addPlayerForm->getData();
            return $formData->getName();
        }
    }

    public function savePlayer($playerName, Player $player) : void
    {
        $player->setName($playerName);
        $player->setTablesOfMatches(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();
    }

    public function getPlayers()
    {
        $players = $this->getDoctrine()
            ->getRepository(Player::class)
            ->findAll();

        if (empty($players)) {
            $players = [];
        };
        return $players;
    }
}
