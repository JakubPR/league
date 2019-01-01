<?php

namespace App\Builder;

use App\Entity\Settings;
use Doctrine\ORM\EntityManagerInterface;

class ConfigurationSettings
{
    public static $states = [
        'createNewGame' => 0,
        'shuffledTable' => 0,
        'numberOfGames' => 0,
    ];

    public $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildStatusTable()
    {
        if (empty($this->em->getRepository('App:Settings')->findAll()))
        {
            foreach (ConfigurationSettings::$states as $name => $value) {
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
       $status =  $this->getStatusByName($statusName);
       return $status->getState();
    }

    public function getStatusByName(string $statusName) : Settings
    {
        return $this->em->getRepository('App:Settings')->findOneBy(['name' => $statusName]);
    }
}