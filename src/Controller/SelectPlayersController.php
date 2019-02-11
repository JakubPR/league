<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\DataValidator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormInterface;
use App\Entity\Player;
use App\Form\SelectPlayersType;

class SelectPlayersController extends AbstractController
{
    /**
     * @Route("/select", name="select_players")
     *
     * @param Request       $request
     * @param DataValidator $validator
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPlayers(Request $request, DataValidator $validator)
    {
        $player = new Player();
        $addPlayerForm = $this->createForm(SelectPlayersType::class, $player);
        $this->getFormData($request, $addPlayerForm, $player, $validator);

        return $this->render(
            'select_players/select.html.twig', [
                'addPlayerForm' => $addPlayerForm->createView(),
                'allPlayers' => $this->getPlayers(),
            ]
        );
    }

    /**
     * @Route("/select/check", name="check_players")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function checkNumberOfPlayers()
    {
        if (0 != count($this->getPlayers()) % 2 || empty($this->getPlayers())) {
            $this->addFlash('notice', 'The number of players is not even, or list is empty.');

            return $this->redirectToRoute('select_players');
        }

        return $this->redirectToRoute('score_table_setup');
    }

    /**
     * @Route("/select/remove/{id}", name="select_remove")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removePlayer(int $id)
    {
        $player = $this->getDoctrine()->getRepository(Player::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($player);
        $em->flush();

        return $this->redirectToRoute('select_players');
    }

    public function getFormData(
        Request $request,
        FormInterface $addPlayerForm,
        Player $player,
        DataValidator $validator
    ): RedirectResponse {
        $addPlayerForm->handleRequest($request);

        if ($addPlayerForm->isSubmitted()) {
            $formData = $addPlayerForm->getData();

            if ($validator->validateName($formData->getname())) {
                $this->savePlayer($formData->getName(), $player);
            }

            return $this->redirectToRoute('select_players');
        }

        return $this->redirectToRoute('select_players');
    }

    public function savePlayer(string $playerName, Player $player)
    {
        $player->setName($playerName);
        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();
    }

    private function getPlayers(): array
    {
        $players = $this->getDoctrine()->getRepository(Player::class)->findAll();

        return $players;
    }
}
