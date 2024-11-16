<?php

namespace App\Core\DTOs;

class ErrorResponse
{
    public string $message;
    public array $errors;
    public int $status;

    public function __construct(string $message, array $errors = [], int $status = 400)
    {
        $this->message = $message;
        $this->errors = $errors;
        $this->status = $status;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'errors' => $this->errors,
            'status' => $this->status,
        ];
    }
}

