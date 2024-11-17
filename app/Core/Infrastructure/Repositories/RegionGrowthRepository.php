<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Domain\Repositories\RegionGrowthRepositoryInterface;
use App\Models\RegionGrowth;

class RegionGrowthRepository implements RegionGrowthRepositoryInterface
{
    public function getAggregatedData(array $filters): array
    {
        // Aplica filtros e retorna dados agregados para gráficos do dashboard
        return RegionGrowth::query()
            ->when($filters['investment_type_id'] ?? null, function ($query, $typeId) {
                $query->where('investment_type_id', $typeId);
            })
            ->selectRaw('region as label, AVG(growth_rate) as value')
            ->groupBy('region')
            ->get()
            ->toArray();
    }

    public function getDetailedData(array $filters): array
    {
        // Aplica filtros e retorna os dados detalhados para a página de detalhes
        return RegionGrowth::query()
            ->when($filters['investment_type_id'] ?? null, function ($query, $typeId) {
                $query->where('investment_type_id', $typeId);
            })
            ->select(['region', 'growth_rate'])
            ->get()
            ->toArray();
    }

    public function filterByInvestmentType(int $investmentTypeId): array
    {
        // Filtra dados específicos por tipo de investimento
        return RegionGrowth::where('investment_type_id', $investmentTypeId)
            ->get()
            ->toArray();
    }
}
