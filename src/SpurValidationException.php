<?php

namespace Spur;

class SpurValidationException extends \Exception
{
    protected $errors;

    public function __construct($message, array $errors)
    {
        parent::__construct($message);

        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
