<?php

namespace App\Core\Domain\UseCases\Auth;

use App\Core\Domain\Exceptions\BusinessRuleException;
use App\Core\Domain\Services\AuthServiceInterface;
use App\Core\Domain\Repositories\UserRepositoryInterface;
use App\Core\DTOs\Auth\RegisterRequestDTO;
use App\Core\Domain\Entities\User;
use Illuminate\Contracts\Hashing\Hasher;

class RegisterUseCase
{
    private AuthServiceInterface $authService;
    private UserRepositoryInterface $userRepository;
    private Hasher $hasher;

    public function __construct(
        AuthServiceInterface $authService,
        UserRepositoryInterface $userRepository,
        Hasher $hasher)
    {
        $this->authService = $authService;
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }

    public function execute(RegisterRequestDTO $dto): string
    {
        $existingUser = $this->userRepository->findByEmail($dto->email);

        if ($existingUser !== null) {
            throw new BusinessRuleException('Email already in use.');
        }

        $hashedPassword = $this->hasher->make($dto->password);

        $eloquentUser = $this->userRepository->create(new User(
            $dto->name,
            $dto->email,
            $hashedPassword
        ));

        $domainUser = new User(
            $eloquentUser->name,
            $eloquentUser->email,
            $eloquentUser->password
        );

        return $this->authService->generateToken($domainUser);
    }
}
