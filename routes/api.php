<?php

use App\Core\Infrastructure\Framework\Laravel\Controllers\AuthController;
use App\Core\Infrastructure\Framework\Laravel\Controllers\DashboardController;
use App\Core\Infrastructure\Framework\Laravel\Middleware\ForceJsonResponse;
use Illuminate\Support\Facades\Route;

Route::middleware([ForceJsonResponse::class, 'api'])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
    // Rota para obter os dados detalhados de um gráfico específico
    Route::get('/dashboard/details/{chartType}', [DashboardController::class, 'details'])
        ->name('dashboard.details');
    Route::get('/user', [AuthController::class, 'user']);
    // Rota para obter os dados do dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');


});
