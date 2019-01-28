<?php

namespace App\Builder;

use App\Entity\Settings;
use Doctrine\ORM\EntityManagerInterface;

class SettingsTableBuilder
{
    const CREATE_NEW_GAME = 'createNewGame';
    const SHUFFLED_TABLE = 'shuffledTable';
    const NUMBER_OF_GAMES = 'numberOfGames';

    public static $states = [
        self::CREATE_NEW_GAME => 0,
        self::SHUFFLED_TABLE => 0,
        self::NUMBER_OF_GAMES => 0,
    ];

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildStatusTable()
    {
        if (empty($this->em->getRepository('App:Settings')->findAll())) {
            foreach (SettingsTableBuilder::$states as $name => $value) {
                $status = new Settings();
                $status->setName($name);
                $status->setState($value);
                $this->em->persist($status);
            }
            $this->em->flush();
        }
    }

    public function changeStatusState(string $statusName, int $stateVariable)
    {
        $statusToChange = $this->getStatusByName($statusName);
        $statusToChange->setState($stateVariable);

        $this->em->persist($statusToChange);
        $this->em->flush();
    }

    public function getStatusState(string $statusName)
    {
        $status = $this->getStatusByName($statusName);

        return $status->getState();
    }

    public function getStatusByName(string $statusName): Settings
    {
        return $this->em->getRepository('App:Settings')->findOneBy(['name' => $statusName]);
    }
}
