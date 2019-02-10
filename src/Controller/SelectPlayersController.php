<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\DataValidator;
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
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @param Request $request
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
        if (0 != count($this->getPlayers()) % 2) {
            $this->addFlash('notice', 'The number of players must be even.');

            return $this->redirectToRoute('select_players');
        }

        return $this->redirectToRoute('score_table_setup');
    }

    /**
     * @Route("/select/remove/{id}", name="select_remove")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @param int $id
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
    ) {
        $addPlayerForm->handleRequest($request);

        if ($addPlayerForm->isSubmitted()) {
            $formData = $addPlayerForm->getData();

            if (!$this->validate($formData->getname(), $validator)) {
                $this->savePlayer($formData->getName(), $player);
            }
        }

        return null;
    }

    public function savePlayer(string $playerName, Player $player)
    {
        $player->setName($playerName);
        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();
    }

    private function validate($playerName, DataValidator $validator)
    {
        $validator->validatePlayerNameNotBlank($playerName);
        if ($validator->validatePlayerNameNotBlank($playerName)) {
            $this->addFlash('notice', $validator->validatePlayerNameNotBlank($playerName));

            return $this->redirectToRoute('select_players');
        }

        $validator->validatePlayerNameRegex($playerName);
        if ($validator->validatePlayerNameRegex($playerName)) {
            $this->addFlash('notice', $validator->validatePlayerNameRegex($playerName));

            return $this->redirectToRoute('select_players');
        }

        return false;
    }

    private function getPlayers(): array
    {
        $players = $this->getDoctrine()->getRepository(Player::class)->findAll();

        return $players;
    }
}
