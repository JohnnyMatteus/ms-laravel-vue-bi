<?php

namespace App\Exceptions;

use App\Core\Domain\Exceptions\BusinessRuleException;
use Illuminate\Auth\AuthenticationException;
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

        if ($exception instanceof BusinessRuleException) {
            $errorResponse = new ErrorResponse(
                $exception->getMessage(),
                [],
                $exception->getCode()
            );

            return response()->json($errorResponse->toArray(), $exception->getCode());
        }

        return parent::render($request, $exception);
    }
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
