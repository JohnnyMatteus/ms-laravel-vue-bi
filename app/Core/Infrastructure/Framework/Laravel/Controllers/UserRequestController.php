<?php

namespace App\Core\Infrastructure\Framework\Laravel\Controllers;

use App\Core\Domain\Repositories\UserRequestRepositoryInterface;
use Illuminate\Http\JsonResponse;

class UserRequestController
{
    private UserRequestRepositoryInterface $userRequestRepository;

    public function __construct(UserRequestRepositoryInterface $userRequestRepository)
    {
        $this->userRequestRepository = $userRequestRepository;
    }

    public function index(): JsonResponse
    {
        $summary = $this->userRequestRepository->getUserRequestSummary();

        return response()->json($summary);
    }
}
