<?php

namespace App\Core\Infrastructure\Services;

use App\Core\Domain\Services\UserRequestServiceInterface;
use App\Models\UserRequest;

class UserRequestService implements UserRequestServiceInterface
{
    public function logRequest(string $userId, string $endpoint): void
    {
        UserRequest::updateOrCreate(
            ['user_id' => $userId, 'endpoint' => $endpoint],
            ['count' => \DB::raw('count + 1')]
        );
    }

    public function getRequestSummary(): array
    {
        return UserRequest::select('endpoint', \DB::raw('SUM(count) as total_count'))
            ->groupBy('endpoint')
            ->orderByDesc('total_count')
            ->get()
            ->toArray();
    }
}

