<?php

namespace App\Core\Domain\Repositories;

interface PatrimonyEvolutionRepositoryInterface
{
    public function getAggregatedData(array $filters): mixed;

    public function getDetailedData(array $filters): mixed;

    public function filterByInvestmentType(int $investmentTypeId): mixed;

    public function filterByDateRange(array $dateRange): mixed;
}
