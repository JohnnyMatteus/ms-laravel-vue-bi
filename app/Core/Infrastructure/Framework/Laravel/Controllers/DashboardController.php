<?php

namespace App\Core\Infrastructure\Framework\Laravel\Controllers;

use App\Core\Domain\UseCases\Dashboard\DashboardUseCase;
use Illuminate\Http\Request;

class DashboardController
{
    protected DashboardUseCase $dashboardUseCase;

    public function __construct(DashboardUseCase $dashboardUseCase)
    {
        $this->dashboardUseCase = $dashboardUseCase;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['investment_type_id', 'date_range']);
        $data = $this->dashboardUseCase->getDashboardData($filters);

        return response()->json($data);
    }

    public function details(Request $request, string $chartType)
    {
        $filters = $request->only(['investment_type_id', 'date_range']);
        $data = $this->dashboardUseCase->getDetailedData($filters, $chartType);

        return response()->json($data);
    }
}
