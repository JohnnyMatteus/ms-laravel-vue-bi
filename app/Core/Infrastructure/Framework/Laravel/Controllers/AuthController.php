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
    public function __construct(
        RegisterUseCase $registerUseCase,
        LoginUseCase $loginUseCase
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $dto = new RegisterRequestDTO($request->validated());

        $token = $this->registerUseCase->execute($dto);

        return response()->json(['token' => $token], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $dto = new LoginRequestDTO($data);
        $token = $this->loginUseCase->execute($dto);

        return response()->json(['token' => $token]);
    }
}
