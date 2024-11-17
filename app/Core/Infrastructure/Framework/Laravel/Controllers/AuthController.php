<?php

namespace App\Core\Infrastructure\Framework\Laravel\Controllers;

use App\Core\Domain\UseCases\Auth\LoginUseCase;
use App\Core\Domain\UseCases\Auth\RegisterUseCase;
use App\Core\DTOs\Auth\RegisterRequestDTO;
use App\Core\DTOs\Auth\LoginRequestDTO;
use App\Core\Infrastructure\Framework\Laravel\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController
{
    private RegisterUseCase $registerUseCase;
    public function __construct(
        RegisterUseCase $registerUseCase,
        LoginUseCase $loginUseCase
    ) {
        $this->registerUseCase = $registerUseCase;
        $this->loginUseCase = $loginUseCase;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $dto = new RegisterRequestDTO($request->validated());

        $token = $this->registerUseCase->execute($dto);

        return response()->json(['token' => $token], 201);
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $dto = new LoginRequestDTO($request->all());
            $token = $this->loginUseCase->execute($dto);
            return response()->json(['token' => $token], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
