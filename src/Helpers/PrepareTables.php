<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Entity\ScoreTable;
use App\Entity\Settings;
use App\Entity\ShuffledPairs;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\SettingsManager;

class PrepareTables
{
    private $em;
    private $setMan;

    public function __construct(EntityManagerInterface $em, SettingsManager $setMan)
    {
        $this->em = $em;
        $this->setMan = $setMan;
    }

    public function setData()
    {
        $players = $this->em->getRepository('App:Player')->findAll();

        $this->setPairsTable($players);
        $this->setScoreTable($players);
        $this->setSettingsTable();
    }

    private function setScoreTable(array $players)
    {
        foreach ($players as $player) {
            /* @var $player \App\Entity\Player **/
            $tableRow = new ScoreTable();
            $tableRow->setPlayerName($player->getName());
            $tableRow->setPlayerId($player->getId());
            $tableRow->setPoints(0);
            $tableRow->setScore(0);
            $this->em->persist($tableRow);
        }
        $this->em->flush();
    }

    private function setPairsTable(array $players)
    {
        $pairs = $this->sortPlayers($players);

        foreach ($pairs as $pair) {
            $tableRow = new ShuffledPairs();
            $tableRow->setPlayer0($pair[0]);
            $tableRow->setPlayer1($pair[1]);
            $tableRow->setPlayed(0);
            $this->em->persist($tableRow);
        }
        $this->em->flush();
    }

    private function setSettingsTable()
    {
        $settings = $this->em->getRepository('App:Settings')->findAll();

        if (null == $settings) {
            foreach (Settings::$settings as $setting) {
                $tableRow = new Settings();
                $tableRow->setName($setting);
                $tableRow->setState(0);
                $this->em->persist($tableRow);
            }
            $this->em->flush();
        }
    }

    private function sortPlayers(array $players): array
    {
        shuffle($players);
        $result = array_chunk($players, 2);

        return $result;
    }
}
