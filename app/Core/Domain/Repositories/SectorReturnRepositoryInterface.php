<?php

namespace App\Core\Domain\Repositories;

interface SectorReturnRepositoryInterface
{
    public function getAggregatedData(array $filters): mixed;

    public function getDetailedData(array $filters): mixed;

    public function filterByInvestmentType(int $investmentTypeId): mixed;
}
