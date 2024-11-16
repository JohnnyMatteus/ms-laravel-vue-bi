<?php

namespace app\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace('App\Core\Infrastructure\Framework\Laravel\Controllers')
                ->group(base_path('routes/api.php'));
        });
    }
}
