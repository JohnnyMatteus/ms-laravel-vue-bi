<?php

namespace App\Core\Domain\Exceptions;

use Exception;

class AuthException extends Exception
{
    public function __construct(string $message = "Authentication error", int $code = 401, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
