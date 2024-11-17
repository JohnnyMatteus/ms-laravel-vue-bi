<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Domain\Repositories\SectorReturnRepositoryInterface;
use App\Models\SectorReturn;

class SectorReturnRepository implements SectorReturnRepositoryInterface
{
    public function getAggregatedData(array $filters): array
    {
        // Aplica filtros e retorna dados agregados para gráficos do dashboard
        return SectorReturn::query()
            ->when($filters['investment_type_id'] ?? null, function ($query, $typeId) {
                $query->where('investment_type_id', $typeId);
            })
            ->selectRaw('sector as label, AVG(return_percentage) as value')
            ->groupBy('sector')
            ->get()
            ->toArray();
    }

    public function getDetailedData(array $filters): array
    {
        // Aplica filtros e retorna os dados detalhados para a página de detalhes
        return SectorReturn::query()
            ->when($filters['investment_type_id'] ?? null, function ($query, $typeId) {
                $query->where('investment_type_id', $typeId);
            })
            ->select(['sector', 'return_percentage'])
            ->get()
            ->toArray();
    }

    public function filterByInvestmentType(int $investmentTypeId): array
    {
        // Filtra dados específicos por tipo de investimento
        return SectorReturn::where('investment_type_id', $investmentTypeId)
            ->get()
            ->toArray();
    }
}
