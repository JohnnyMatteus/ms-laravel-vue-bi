<?php

namespace Tests\Unit\UseCases;

use Tests\TestCase;
use App\Core\Domain\UseCases\Auth\RegisterUseCase;
use App\Core\Domain\Repositories\UserRepositoryInterface;
use App\Core\Domain\Services\AuthServiceInterface;
use App\Core\DTOs\Auth\RegisterRequestDTO;
use Illuminate\Contracts\Hashing\Hasher;

class RegisterUseCaseTest extends TestCase
{
    public function testUserRegistrationSuccess()
    {
        $repository = $this->createMock(UserRepositoryInterface::class);
        $authService = $this->createMock(AuthServiceInterface::class);
        $hasher = $this->createMock(Hasher::class);

        $repository->method('findByEmail')->willReturn(null);
        $repository->method('create')->willReturn(new \App\Models\User([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'hashed-password',
        ]));

        $hasher->method('make')->willReturn('hashed-password');
        $authService->method('generateToken')->willReturn('dummy-token');

        $useCase = new RegisterUseCase($authService, $repository, $hasher);

        $dto = new RegisterRequestDTO([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'supersecret',
        ]);

        $result = $useCase->execute($dto);

        $this->assertEquals('dummy-token', $result);
    }

    public function testEmailAlreadyInUse()
    {
        $repository = $this->createMock(UserRepositoryInterface::class);
        $authService = $this->createMock(AuthServiceInterface::class);
        $hasher = $this->createMock(Hasher::class);

        // Mock para simular um usuário existente
        $repository->method('findByEmail')->willReturn(
            new \App\Core\Domain\Entities\User(
                'Existing User',
                'john@example.com',
                'hashed-password'
            )
        );

        $useCase = new RegisterUseCase($authService, $repository, $hasher);

        $this->expectException(\App\Core\Domain\Exceptions\BusinessRuleException::class);
        $this->expectExceptionMessage('Email already in use.');

        $dto = new \App\Core\DTOs\Auth\RegisterRequestDTO([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'supersecret',
        ]);

        $useCase->execute($dto);
    }

}
