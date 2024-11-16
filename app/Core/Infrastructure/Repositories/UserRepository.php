<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Domain\Repositories\UserRepositoryInterface;
use App\Core\Domain\Entities\User;
use App\Models\User as EloquentUser;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function create(User $user): User
    {
        $eloquentUser = EloquentUser::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => Hash::make($user->password)
        ]);

        return new User($eloquentUser->name, $eloquentUser->email, $eloquentUser->password);
    }

    public function findByEmail(string $email): ?User
    {
        $eloquentUser = EloquentUser::where('email', $email)->first();

        if (!$eloquentUser) {
            return null;
        }

        return new User($eloquentUser->name, $eloquentUser->email, $eloquentUser->password);
    }
}
