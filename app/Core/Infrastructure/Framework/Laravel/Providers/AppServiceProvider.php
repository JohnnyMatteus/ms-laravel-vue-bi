<?php

namespace App\Core\Infrastructure\Framework\Laravel\Providers;

use App\Core\Domain\Repositories\UserRepositoryInterface;
use App\Core\Domain\Services\AuthServiceInterface;
use App\Core\Domain\UseCases\Auth\RegisterUseCase;
use App\Core\Infrastructure\Framework\Laravel\LaravelMiddleware\BlockNonApiAccess;
use App\Core\Infrastructure\Repositories\UserRepository;
use App\Core\Infrastructure\Services\AuthService;
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
