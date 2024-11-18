<?php

namespace App\Core\Infrastructure\Framework\Laravel\Middleware;

use Closure;
use App\Core\Domain\UseCases\LogUserRequestUseCase;

class LogUserRequestMiddleware
{
    private LogUserRequestUseCase $logUserRequestUseCase;

    public function __construct(LogUserRequestUseCase $logUserRequestUseCase)
    {
        $this->logUserRequestUseCase = $logUserRequestUseCase;
    }

    public function handle($request, Closure $next)
    {
        // Dados para registrar a requisição
        $data = [
            'user_id' => auth()->id(),
            'endpoint' => $request->path(),
        ];

        // Executa o caso de uso
        $this->logUserRequestUseCase->execute($data);

        return $next($request);
    }
}
