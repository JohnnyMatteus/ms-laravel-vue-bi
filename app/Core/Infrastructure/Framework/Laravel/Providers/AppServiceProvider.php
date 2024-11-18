<?php

namespace App\Core\Infrastructure\Framework\Laravel\Providers;

use App\Core\Domain\Repositories\ActionReturnRepositoryInterface;
use App\Core\Domain\Repositories\AssetDistributionRepositoryInterface;
use App\Core\Domain\Repositories\PatrimonyEvolutionRepositoryInterface;
use App\Core\Domain\Repositories\RegionGrowthRepositoryInterface;
use App\Core\Domain\Repositories\SectorReturnRepositoryInterface;
use App\Core\Domain\Repositories\UserRepositoryInterface;
use App\Core\Domain\Repositories\UserRequestRepositoryInterface;
use App\Core\Domain\Services\AuthServiceInterface;
use App\Core\Domain\Services\DashboardServiceInterface;
use App\Core\Domain\Services\UserRequestServiceInterface;
use App\Core\Domain\UseCases\Auth\RegisterUseCase;
use App\Core\Infrastructure\Framework\Laravel\LaravelMiddleware\BlockNonApiAccess;
use App\Core\Infrastructure\Repositories\ActionReturnRepository;
use App\Core\Infrastructure\Repositories\AssetDistributionRepository;
use App\Core\Infrastructure\Repositories\PatrimonyEvolutionRepository;
use App\Core\Infrastructure\Repositories\RegionGrowthRepository;
use App\Core\Infrastructure\Repositories\SectorReturnRepository;
use App\Core\Infrastructure\Repositories\UserRepository;
use App\Core\Infrastructure\Repositories\UserRequestRepository;
use App\Core\Infrastructure\Services\AuthService;
use App\Core\Infrastructure\Services\DashboardService;
use App\Core\Infrastructure\Services\UserRequestService;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(ActionReturnRepositoryInterface::class, ActionReturnRepository::class);
        $this->app->bind(PatrimonyEvolutionRepositoryInterface::class, PatrimonyEvolutionRepository::class);
        $this->app->bind(AssetDistributionRepositoryInterface::class, AssetDistributionRepository::class);
        $this->app->bind(SectorReturnRepositoryInterface::class, SectorReturnRepository::class);
        $this->app->bind(RegionGrowthRepositoryInterface::class, RegionGrowthRepository::class);
        $this->app->bind(DashboardServiceInterface::class, DashboardService::class);
        $this->app->bind(UserRequestServiceInterface::class, UserRequestService::class);
        $this->app->bind(UserRequestRepositoryInterface::class, UserRequestRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
