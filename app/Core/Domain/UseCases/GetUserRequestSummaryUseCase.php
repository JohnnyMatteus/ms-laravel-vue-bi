<?php

namespace App\Core\Domain\UseCases;

use App\Core\Domain\Services\UserRequestServiceInterface;

class GetUserRequestSummaryUseCase
{
    private UserRequestServiceInterface $service;

    public function __construct(UserRequestServiceInterface $service)
    {
        $this->service = $service;
    }

    public function execute(): array
    {
        return $this->service->getRequestSummary();
    }
}
