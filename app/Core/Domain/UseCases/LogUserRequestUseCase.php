<?php

namespace App\Core\Domain\UseCases;

use App\Core\Domain\Services\UserRequestServiceInterface;

class LogUserRequestUseCase
{
    private UserRequestServiceInterface $service;

    public function __construct(UserRequestServiceInterface $service)
    {
        $this->service = $service;
    }

    public function execute(string $userId, string $endpoint): void
    {
        $this->service->logRequest($userId, $endpoint);
    }
}
