<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @method addFlash(string $string, $getMessage)
 */
class DataValidator
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return string
     *
     * @param string $score
     */
    public function validateScore(string $score): string
    {
        $message = '';
        $scoreConstraint = new Assert\NotBlank();
        $errors = $this->validator->validate(
            $score,
            $scoreConstraint
        );

        if (0 != count($errors)) {
            $message = $errors[0]->getMessage();
        }

        return $message;
    }
}
