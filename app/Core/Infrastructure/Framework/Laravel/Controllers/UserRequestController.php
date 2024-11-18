<?php

namespace App\Core\Infrastructure\Framework\Laravel\Controllers;

use App\Core\Domain\UseCases\GetUserRequestSummaryUseCase;

class UserRequestController
{
    private GetUserRequestSummaryUseCase $summaryUseCase;

    public function __construct(GetUserRequestSummaryUseCase $summaryUseCase)
    {
        $this->summaryUseCase = $summaryUseCase;
    }

    public function index()
    {
        $summary = $this->summaryUseCase->execute();
        return response()->json($summary);
    }
}
