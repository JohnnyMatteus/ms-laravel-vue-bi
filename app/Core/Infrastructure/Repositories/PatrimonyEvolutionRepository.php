<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Domain\Repositories\PatrimonyEvolutionRepositoryInterface;
use App\Models\PatrimonyEvolution;
use Illuminate\Support\Facades\DB;

class PatrimonyEvolutionRepository implements PatrimonyEvolutionRepositoryInterface
{
    public function getAggregatedData(array $filters): mixed
    {
        return PatrimonyEvolution::query()
            ->when($filters['investment_type_id'] ?? null, function ($query, $typeId) {
                $query->where('investment_type_id', $typeId);
            })
            ->when($filters['date_range'] ?? null, function ($query, $dateRange) {
                $query->whereBetween('date', $dateRange);
            })
            ->selectRaw('month as period, SUM(value) as total_value')
            ->groupBy('month')
            ->get()
            ->toArray();
    }

    public function getDetailedData(array $filters): mixed
    {
        return PatrimonyEvolution::query()
            ->when($filters['investment_type_id'] ?? null, function ($query, $typeId) {
                $query->where('investment_type_id', $typeId);
            })
            ->when($filters['date_range'] ?? null, function ($query, $dateRange) {
                $query->whereBetween('date', $dateRange);
            })
            ->select(['month', 'value', 'description'])
            ->get()
            ->toArray();
    }

    public function filterByInvestmentType(int $investmentTypeId): mixed
    {
        return PatrimonyEvolution::where('investment_type_id', $investmentTypeId)
            ->get()
            ->toArray();
    }

    public function filterByDateRange(array $dateRange): mixed
    {
        return PatrimonyEvolution::query()
            ->whereBetween('date', $dateRange)
            ->get()
            ->toArray();
    }
}
