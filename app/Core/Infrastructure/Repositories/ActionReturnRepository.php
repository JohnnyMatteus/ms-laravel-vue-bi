<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Domain\Repositories\ActionReturnRepositoryInterface;
use App\Models\ActionReturn;
use Illuminate\Support\Facades\DB;

class ActionReturnRepository implements ActionReturnRepositoryInterface
{
    public function getAggregatedData(array $filters): mixed
    {
        return $this->applyFilters(ActionReturn::query(), $filters)
            ->select('action_code', DB::raw('AVG(return_percentage) as average_return'))
            ->groupBy('action_code')
            ->get();
    }

    public function getDetailedData(array $filters): mixed
    {
        return $this->applyFilters(ActionReturn::query(), $filters)->get();
    }

    public function filterByInvestmentType(int $investmentTypeId): mixed
    {
        return ActionReturn::where('investment_type_id', $investmentTypeId)->get();
    }

    public function filterByDateRange(array $dateRange): mixed
    {
        return ActionReturn::whereBetween('date', $dateRange)->get();
    }

    private function applyFilters($query, array $filters)
    {
        if (isset($filters['investment_type_id'])) {
            $query->where('investment_type_id', $filters['investment_type_id']);
        }

        if (isset($filters['date_range'])) {
            $query->whereBetween('date', $filters['date_range']);
        }

        return $query;
    }
}
