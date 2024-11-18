<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Domain\Repositories\UserRequestRepositoryInterface;
use App\Models\UserRequest;

class UserRequestRepository implements UserRequestRepositoryInterface
{
    public function logRequest(string $userId, string $endpoint): void
    {
        UserRequest::updateOrCreate(
            ['user_id' => $userId, 'endpoint' => $endpoint],
            ['count' => \DB::raw('count + 1')]
        );
    }

    public function getRequestsSummary(): array
    {
        return UserRequest::select('endpoint', \DB::raw('SUM(count) as total_count'))
            ->groupBy('endpoint')
            ->get()
            ->toArray();
    }
}
