<?php

namespace App\Core\Infrastructure\Services;

use App\Models\User;

class AuthService
{
    public function generateToken(User $user): string
    {
        return $user->createToken('API Token')->plainTextToken;
    }
}
