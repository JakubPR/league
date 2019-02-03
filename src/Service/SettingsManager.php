<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Settings;
use Doctrine\ORM\EntityManagerInterface;

class SettingsManager
{
    public static $NUMBER_OF_GAMES = 'numberOfGames';
    public static $REVENGES = 'revenges';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function changeSettings(string $settingName, int $settingValue)
    {
        $settingToChange = $this->findSetting($settingName);
        $settingToChange->setState($settingValue);
        $this->em->persist($settingToChange);
        $this->em->flush();
    }

    public function getSettingValue(string $settingName): int
    {
        $settingValue = $this->findSetting($settingName);
        return $settingValue->getState();
    }

    private function findSetting(string $settingName): Settings
    {
        return $this->em->getRepository('App:Settings')->findOneBy(['name' => $settingName]);
    }
}
