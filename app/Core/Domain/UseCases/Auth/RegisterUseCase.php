<?php

namespace App\Core\Domain\UseCases\Auth;

use App\Core\Domain\Entities\User;
use App\Core\Domain\Exceptions\BusinessRuleException;
use App\Core\Domain\Repositories\UserRepositoryInterface;
use App\Core\DTOs\Auth\RegisterRequestDTO;
use App\Core\Infrastructure\Services\AuthService;
use Illuminate\Contracts\Hashing\Hasher;

class RegisterUseCase
{
    private AuthService $authService;
    private UserRepositoryInterface $userRepository;

    private Hasher $hasher;
    public function __construct(
        UserRepositoryInterface $userRepository,
        AuthService $authService,
        Hasher $hasher
    )
    {
        $this->userRepository = $userRepository;
        $this->authService = $authService;
        $this->hasher = $hasher;
    }

    public function execute(RegisterRequestDTO $dto): string
    {
        if ($this->userRepository->findByEmail($dto->email)) {
            throw new BusinessRuleException('Email already in use.');
        }

        $hashedPassword = $this->hasher->make($dto->password);

        $user = $this->userRepository->create(new User(
            $dto->name,
            $dto->email,
            $hashedPassword
        ));

        return $this->authService->generateToken($user);
    }
}
