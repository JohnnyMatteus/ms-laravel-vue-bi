<?php

namespace App\Core\Domain\UseCases\Auth;

use App\Core\Domain\Exceptions\AuthException;
use App\Core\Domain\Exceptions\BusinessRuleException;
use App\Core\Domain\Services\AuthServiceInterface;
use App\Core\Domain\Repositories\UserRepositoryInterface;
use App\Core\DTOs\Auth\LoginRequestDTO;

class LoginUseCase
{
    private AuthServiceInterface $authService;
    private UserRepositoryInterface $userRepository;

    public function __construct(AuthServiceInterface $authService, UserRepositoryInterface $userRepository)
    {
        $this->authService = $authService;
        $this->userRepository = $userRepository;
    }

    public function execute(LoginRequestDTO $dto): string
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (!$user || !$this->authService->checkPassword($user, $dto->password)) {
            throw new BusinessRuleException('Invalid credentials');
        }

        return $this->authService->generateToken($user);
    }
}
