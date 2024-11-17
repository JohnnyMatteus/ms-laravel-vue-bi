<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Domain\Repositories\AssetDistributionRepositoryInterface;
use App\Models\AssetDistribution;

class AssetDistributionRepository implements AssetDistributionRepositoryInterface
{
    public function getAggregatedData(array $filters): array
    {
        // Aplica filtros e retorna dados agregados para gráficos do dashboard
        return AssetDistribution::query()
            ->when($filters['investment_type_id'] ?? null, function ($query, $typeId) {
                $query->where('investment_type_id', $typeId);
            })
            ->selectRaw('category as label, SUM(percentage) as value')
            ->groupBy('category')
            ->get()
            ->toArray();
    }

    public function getDetailedData(array $filters): array
    {
        // Aplica filtros e retorna os dados detalhados para a página de detalhes
        return AssetDistribution::query()
            ->when($filters['investment_type_id'] ?? null, function ($query, $typeId) {
                $query->where('investment_type_id', $typeId);
            })
            ->select(['category', 'percentage', 'details'])
            ->get()
            ->toArray();
    }

    public function filterByInvestmentType(int $investmentTypeId): array
    {
        // Filtra dados específicos por tipo de investimento
        return AssetDistribution::where('investment_type_id', $investmentTypeId)
            ->get()
            ->toArray();
    }
}
