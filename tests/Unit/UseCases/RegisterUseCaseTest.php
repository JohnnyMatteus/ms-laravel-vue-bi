<?php

namespace Tests\Unit\UseCases;

use App\Core\Domain\Exceptions\BusinessRuleException;
use App\Core\Domain\Repositories\UserRepositoryInterface;
use App\Core\DTOs\Auth\RegisterRequestDTO;
use App\Core\Domain\Entities\User as DomainUser;
use App\Models\User as EloquentUser;
use App\Core\Infrastructure\Services\AuthService;
use App\Core\Domain\UseCases\Auth\RegisterUseCase;
use Illuminate\Contracts\Hashing\Hasher;
use PHPUnit\Framework\TestCase;

class RegisterUseCaseTest extends TestCase
{
    public function testUserRegistrationSuccess()
    {
        $repository = $this->createMock(UserRepositoryInterface::class);
        $authService = $this->createMock(AuthService::class);
        $hasher = $this->createMock(Hasher::class);

        // Mock do comportamento esperado
        $repository->method('findByEmail')->willReturn(null);

        $eloquentUser = new class extends \App\Models\User {
            public function __construct()
            {
                $this->attributes = [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'password' => 'hashed-password',
                ];
            }
        };

        $repository->method('create')->willReturn($eloquentUser);

        $hasher->method('make')->willReturn('hashed-password');
        $authService->method('generateToken')->willReturn('dummy-token');

        $useCase = new RegisterUseCase($repository, $authService, $hasher);

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
        $authService = $this->createMock(AuthService::class);
        $hasher = $this->createMock(Hasher::class);

        // Mock para retorno de DomainUser no findByEmail
        $repository->method('findByEmail')->willReturn(new DomainUser(
            'John Doe',
            'john@example.com',
            'hashed-password'
        ));

        $useCase = new RegisterUseCase($repository, $authService, $hasher);

        $dto = new RegisterRequestDTO([
            'name' => 'Jane Doe',
            'email' => 'john@example.com',
            'password' => 'supersecret'
        ]);

        $this->expectException(BusinessRuleException::class);
        $this->expectExceptionMessage('Email already in use.');

        $useCase->execute($dto);
    }
}
