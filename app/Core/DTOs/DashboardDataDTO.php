<?php

namespace App\Core\DTOs;

class DashboardDataDTO
{
    public function __construct(
        public array $actionReturns,
        public array $patrimonyEvolution,
        public array $assetDistribution,
        public array $sectorReturns,
        public array $regionGrowth
    ) {}
}
