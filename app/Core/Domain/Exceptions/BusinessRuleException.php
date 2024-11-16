<?php

namespace App\Core\Domain\Exceptions;

use Exception;

class BusinessRuleException extends Exception
{
    public function __construct(string $message = 'Business rule violation', int $code = 400)
    {
        parent::__construct($message, $code);
    }
}

