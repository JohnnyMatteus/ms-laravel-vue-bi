<?php

namespace App\Core\Infrastructure\Framework\Laravel\Middleware;

use App\Core\Domain\UseCases\LogUserRequestUseCase;
use Illuminate\Support\Facades\Auth;

class LogUserRequestMiddleware
{
    private LogUserRequestUseCase $logUseCase;

    public function __construct(LogUserRequestUseCase $logUseCase)
    {
        $this->logUseCase = $logUseCase;
    }

    public function handle($request, \Closure $next)
    {
        if (Auth::check()) {
            $this->logUseCase->execute(Auth::id(), $request->path());
        }

        return $next($request);
    }
}
