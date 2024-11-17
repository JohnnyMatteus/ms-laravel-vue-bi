<?php

namespace App\Core\Domain\UseCases\Dashboard;

use App\Core\Domain\Repositories\ActionReturnRepositoryInterface;
use App\Core\Domain\Repositories\AssetDistributionRepositoryInterface;
use App\Core\Domain\Repositories\PatrimonyEvolutionRepositoryInterface;
use App\Core\Domain\Repositories\RegionGrowthRepositoryInterface;
use App\Core\Domain\Repositories\SectorReturnRepositoryInterface;

class DashboardUseCase
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

    /**
     * Retorna os dados agregados para o dashboard.
     */
    public function getDashboardData(array $filters): array
    {
        return [
            'actionReturns' => $this->actionReturnRepository->getAggregatedData($filters),
            'patrimonyEvolution' => $this->patrimonyEvolutionRepository->getAggregatedData($filters),
            'assetDistribution' => $this->assetDistributionRepository->getAggregatedData($filters),
            'sectorReturns' => $this->sectorReturnRepository->getAggregatedData($filters),
            'regionGrowth' => $this->regionGrowthRepository->getAggregatedData($filters),
        ];
    }

    public function getDetailedData(array $filters, string $chartType): array
    {
        switch ($chartType) {
            case 'actionReturns':
                return $this->actionReturnRepository->getDetailedData($filters);
            case 'patrimonyEvolution':
                return $this->patrimonyEvolutionRepository->getDetailedData($filters);
            case 'assetDistribution':
                return $this->assetDistributionRepository->getDetailedData($filters);
            case 'sectorReturns':
                return $this->sectorReturnRepository->getDetailedData($filters);
            case 'regionGrowth':
                return $this->regionGrowthRepository->getDetailedData($filters);
            default:
                throw new \InvalidArgumentException("Invalid chart type: $chartType");
        }
    }

}
