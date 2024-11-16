<?php

namespace App\Core\DTOs\Auth;

class RegisterRequestDTO
{
    public string $name;
    public string $email;
    public string $password;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->password = $data['password'];
    }
}
