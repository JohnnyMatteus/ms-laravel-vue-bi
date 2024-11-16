<?php

use App\Core\Infrastructure\Framework\Laravel\Controllers\AuthController;
use App\Core\Infrastructure\Framework\Laravel\Middleware\ForceJsonResponse;
use Illuminate\Support\Facades\Route;

Route::middleware([ForceJsonResponse::class, 'api'])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
});
