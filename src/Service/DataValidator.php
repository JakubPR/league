<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @method addFlash(string $string, $getMessage)
 */
class DataValidator extends AbstractController
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param string $score
     * @return string
     */
    public function validateScore(string $score): string
    {
        $message = '';
        $rangeConstraint = new Assert\Range(['min' => 0, 'max' => 8]);
        $errors = $this->validator->validate(
            $score,
            $rangeConstraint
        );

        if (0 != count($errors)) {
            $message = $errors[0]->getMessage();
        }
        return $message;
    }

    public function validateName($playerName)
    {
        $this->validatePlayerNameNotBlank($playerName);
        if ($this->validatePlayerNameNotBlank($playerName)) {
            $this->addFlash('notice', $this->validatePlayerNameNotBlank($playerName));
            return false;
        }

        $this->validatePlayerNameRegex($playerName);
        if ($this->validatePlayerNameRegex($playerName)) {
            $this->addFlash('notice', $this->validatePlayerNameRegex($playerName));
            return false;
        }
        return true;
    }

    private function validatePlayerNameRegex(string $name)
    {
        $message = '';
        $regexConstraint = new Assert\Regex([
            'pattern' => '/^([A-Za-z]+)$/',
        ]);
        $regexConstraint->message = 'Please use letters.';

        $errors = $this->validator->validate(
            $name,
            $regexConstraint
        );

        if (0 != count($errors)) {
            $message = $errors[0]->getMessage();
        }
        return $message;
    }

    private function validatePlayerNameNotBlank($name)
    {
        $message = '';
        $notBlankConstraint = new Assert\NotBlank();
        $notBlankConstraint->message = 'Name can not be blank.';

        $errors = $this->validator->validate(
            $name,
            $notBlankConstraint
        );

        if (0 != count($errors)) {
            $message = $errors[0]->getMessage();
        }
        return $message;
    }
}
