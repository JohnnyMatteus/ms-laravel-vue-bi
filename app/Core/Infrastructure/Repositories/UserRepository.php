<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Domain\Repositories\UserRepositoryInterface;
use App\Core\Domain\Entities\User as DomainUser;
use App\Models\User as EloquentUser;

class UserRepository implements UserRepositoryInterface
{
    public function create(DomainUser $user): EloquentUser
    {
        return EloquentUser::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
        ]);
    }

    public function findByEmail(string $email): ?DomainUser
    {
        $eloquentUser = EloquentUser::where('email', $email)->first();

        if (!$eloquentUser) {
            return null;
        }

        return new DomainUser(
            name: $eloquentUser->name,
            email: $eloquentUser->email,
            password: $eloquentUser->password
        );
    }
}
