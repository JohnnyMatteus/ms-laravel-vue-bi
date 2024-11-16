<?php

namespace App\Core\Domain\UseCases\Auth;

use App\Core\Domain\Exceptions\BusinessRuleException;
use App\Core\Domain\Repositories\UserRepositoryInterface;
use App\Core\DTOs\Auth\RegisterRequestDTO;
use App\Core\Infrastructure\Services\AuthService;

class RegisterUseCase
{
    public function __construct(
        UserRepositoryInterface $userRepository,
        AuthService $authService
    )
    {}

    public function execute(RegisterRequestDTO $dto): string
    {
        if ($this->userRepository->existsByEmail($dto->email)) {
            throw new BusinessRuleException('Email already in use.');
        }

        $user = $this->userRepository->create($dto->toArray());

        return $this->authService->generateToken($user);
    }
}
