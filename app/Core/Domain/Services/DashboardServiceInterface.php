<?php

namespace App\Core\Domain\Services;

interface DashboardServiceInterface
{
    public function getDashboardData(array $filters): array;

    public function getDetailedData(array $filters, string $chartType): array;
}
