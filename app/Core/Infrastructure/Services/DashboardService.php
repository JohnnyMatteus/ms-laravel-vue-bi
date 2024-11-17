<?php

namespace App\Core\Infrastructure\Services;

use App\Core\Domain\Repositories\ActionReturnRepositoryInterface;
use App\Core\Domain\Repositories\AssetDistributionRepositoryInterface;
use App\Core\Domain\Repositories\PatrimonyEvolutionRepositoryInterface;
use App\Core\Domain\Repositories\RegionGrowthRepositoryInterface;
use App\Core\Domain\Repositories\SectorReturnRepositoryInterface;
use App\Core\Domain\Services\DashboardServiceInterface;

class DashboardService implements DashboardServiceInterface
{
    protected ActionReturnRepositoryInterface $actionReturnRepository;
    protected PatrimonyEvolutionRepositoryInterface $patrimonyEvolutionRepository;
    protected AssetDistributionRepositoryInterface $assetDistributionRepository;
    protected SectorReturnRepositoryInterface $sectorReturnRepository;
    protected RegionGrowthRepositoryInterface $regionGrowthRepository;

    public function __construct(
        ActionReturnRepositoryInterface $actionReturnRepository,
        PatrimonyEvolutionRepositoryInterface $patrimonyEvolutionRepository,
        AssetDistributionRepositoryInterface $assetDistributionRepository,
        SectorReturnRepositoryInterface $sectorReturnRepository,
        RegionGrowthRepositoryInterface $regionGrowthRepository
    ) {
        $this->actionReturnRepository = $actionReturnRepository;
        $this->patrimonyEvolutionRepository = $patrimonyEvolutionRepository;
        $this->assetDistributionRepository = $assetDistributionRepository;
        $this->sectorReturnRepository = $sectorReturnRepository;
        $this->regionGrowthRepository = $regionGrowthRepository;
    }

    public function getDashboardData(array $filters): array
    {
        return [
            'action_returns' => $this->actionReturnRepository->getAggregatedData($filters),
            'patrimony_evolution' => $this->patrimonyEvolutionRepository->getAggregatedData($filters),
            'asset_distribution' => $this->assetDistributionRepository->getAggregatedData($filters),
            'sector_returns' => $this->sectorReturnRepository->getAggregatedData($filters),
            'region_growth' => $this->regionGrowthRepository->getAggregatedData($filters),
        ];
    }

    public function getDetailedData(array $filters, string $chartType): array
    {
        switch ($chartType) {
            case 'action_returns':
                return $this->actionReturnRepository->getDetailedData($filters);
            case 'patrimony_evolution':
                return $this->patrimonyEvolutionRepository->getDetailedData($filters);
            case 'asset_distribution':
                return $this->assetDistributionRepository->getDetailedData($filters);
            case 'sector_returns':
                return $this->sectorReturnRepository->getDetailedData($filters);
            case 'region_growth':
                return $this->regionGrowthRepository->getDetailedData($filters);
            default:
                throw new \InvalidArgumentException("Invalid chart type: {$chartType}");
        }
    }
}
