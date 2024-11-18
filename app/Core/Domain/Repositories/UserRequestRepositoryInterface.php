<?php

namespace App\Core\Domain\Repositories;

interface UserRequestRepositoryInterface
{
    public function logRequest(string $userId, string $endpoint): void;

    public function getRequestsSummary(): array;
}
