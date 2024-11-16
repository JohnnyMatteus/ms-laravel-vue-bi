<?php

namespace App\Core\Domain\UseCases\Auth;

use App\Core\Domain\Repositories\UserRepositoryInterface;
use App\Core\DTOs\Auth\LoginRequestDTO;
use Illuminate\Support\Facades\Auth;

class LoginUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(LoginRequestDTO $dto): string
    {
        if (!Auth::attempt(['email' => $dto->email, 'password' => $dto->password])) {
            throw new \Exception('Invalid credentials');
        }

        $user = Auth::user();

        return $user->createToken('Personal Access Token')->accessToken;
    }
}
