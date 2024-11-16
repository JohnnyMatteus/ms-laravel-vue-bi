<?php

namespace App\Core\Infrastructure\Services;

use App\Models\User;

class AuthService
{
    public function generateToken(User $user): string
    {
        $tokenResult = $user->createToken('API Token');

        return $tokenResult->accessToken;
    }
}
