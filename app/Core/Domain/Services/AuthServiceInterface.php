<?php

namespace App\Core\Domain\Services;

use App\Core\Domain\Entities\User;

interface AuthServiceInterface
{
    public function checkPassword(User $user, string $password): bool;
    public function generateToken(User $user): string;
}

