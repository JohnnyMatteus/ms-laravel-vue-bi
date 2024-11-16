<?php

namespace App\Core\Domain\Repositories;

use App\Core\Domain\Entities\User;
use App\Models\User as EloquentUser;

interface UserRepositoryInterface
{
    public function create(User $user): EloquentUser;
    public function findByEmail(string $email): ?User;
}
