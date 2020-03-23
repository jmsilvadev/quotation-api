<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationException extends Exception
{
    private $violations;

    public function __construct(ConstraintViolationList $violations)
    {
        $this->violations = $violations;
    }

    public function getMessages(): array
    {
        $messages = [];
        foreach ($this->violations as $violation) {
                $messages[$violation->getPropertyPath()][] = $violation->getMessage();
        }
        
        return $messages;
    }
}
