<?php

namespace App\Core\Domain\UseCases;

use App\Core\Domain\Repositories\UserRequestRepositoryInterface;

class LogUserRequestUseCase
{
    private UserRequestRepositoryInterface $userRequestRepository;

    public function __construct(UserRequestRepositoryInterface $userRequestRepository)
    {
        $this->userRequestRepository = $userRequestRepository;
    }

    public function execute(array $data): void
    {
        $this->userRequestRepository->logRequest($data);
    }
}


