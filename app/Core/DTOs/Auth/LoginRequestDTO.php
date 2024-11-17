<?php

namespace App\Core\DTOs\Auth;

class LoginRequestDTO
{
    public string $email;
    public string $password;

    public function __construct(array $data)
    {
        $this->email = $data['email'] ?? '';
        $this->password = $data['password'] ?? '';
    }
}