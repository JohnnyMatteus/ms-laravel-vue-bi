<?php

namespace App\Core\Infrastructure\Framework\Laravel\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use App\Core\DTOs\ErrorResponse;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            $errorResponse = new ErrorResponse(
                'Validation Error',
                $exception->errors(),
                422
            );

            return response()->json($errorResponse->toArray(), 422);
        }

        return parent::render($request, $exception);
    }
}
