<?php

namespace App\Controller;

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
     */
    public function index(Request $request)
    {
        $player = new Player();
        $addPlayerForm = $this->createForm(ManagePlayersType::class, $player);
        $this->getFormData($request, $addPlayerForm, $player);

        return $this->render(
                'manage players/index.html.twig', [
                'addPlayerForm' => $addPlayerForm->createView(),
                'allPlayers' => $this->getPlayers(),
                ]
            );
    }

    /**
     * @Route("/manage-players/remove/{id}", name="manage-players-remove")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removePlayer(int $id)
    {
        $player = $this->getDoctrine()
            ->getRepository(Player::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($player);
        $em->flush();

        return $this->redirectToRoute('manage-players');
    }

    public function getFormData(Request $request, FormInterface $addPlayerForm, Player $player)
    {
        $addPlayerForm->handleRequest($request);

        if ($addPlayerForm->isSubmitted()) {
            $formData = $addPlayerForm->getData();
            $this->savePlayer($formData->getName(), $player);
        }
    }

    public function savePlayer($playerName, Player $player)
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

        return $players;
    }
}
