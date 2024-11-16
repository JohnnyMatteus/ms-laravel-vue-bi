<?php

namespace App\Core\Infrastructure\Framework\Laravel\LaravelMiddleware;

use Closure;
use Illuminate\Http\Request;

class BlockNonApiAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Bloqueia acessos que não começam com "/api"
        if (!str_starts_with($request->path(), 'api')) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied: Only API routes are allowed.',
            ], 403);
        }

        return $next($request);
    }
}
