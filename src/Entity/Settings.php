<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SettingsRepository")
 */
class Settings
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $state;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function setState(int $state): Settings
    {
        $this->state = $state;

        return $this;
    }

    public function setName($name): Settings
    {
        $this->name = $name;

        return $this;
    }
}
