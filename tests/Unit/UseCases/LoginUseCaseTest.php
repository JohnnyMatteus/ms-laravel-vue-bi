<?php

namespace Tests\Unit\UseCases;

use App\Core\Domain\UseCases\Auth\LoginUseCase;
use App\Core\Domain\Repositories\UserRepositoryInterface;
use App\Core\Domain\Services\AuthServiceInterface;
use App\Core\Domain\Exceptions\BusinessRuleException;
use App\Core\Domain\Entities\User;
use App\Core\DTOs\Auth\LoginRequestDTO;
use Illuminate\Contracts\Hashing\Hasher;
use PHPUnit\Framework\TestCase;

class LoginUseCaseTest extends TestCase
{
    public function testLoginSuccess()
    {
        $repository = $this->createMock(UserRepositoryInterface::class);

        $authService = $this->createMock(AuthServiceInterface::class);

        $hasher = $this->createMock(Hasher::class);

        $user = new User('John Doe', 'john@example.com', 'hashed-password');

        $repository->method('findByEmail')
            ->with('john@example.com')
            ->willReturn($user);

        $authService->method('checkPassword')
            ->with($user, 'supersecret')
            ->willReturn(true);

        $authService->method('generateToken')
            ->with($user)
            ->willReturn('dummy-token');

        $useCase = new LoginUseCase($authService, $repository, $hasher);

        $dto = new LoginRequestDTO([
            'email' => 'john@example.com',
            'password' => 'supersecret',
        ]);

        $result = $useCase->execute($dto);

        $this->assertEquals('dummy-token', $result);
    }

    public function testInvalidCredentials()
    {
        $repository = $this->createMock(UserRepositoryInterface::class);
        $authService = $this->createMock(AuthServiceInterface::class);
        $hasher = $this->createMock(Hasher::class);

        $user = new User('John Doe', 'john@example.com', 'hashed-password');

        $repository->method('findByEmail')->with('john@example.com')->willReturn($user);
        $hasher->method('check')->with('wrong-password', 'hashed-password')->willReturn(false);

        $useCase = new LoginUseCase($authService, $repository, $hasher);

        $dto = new LoginRequestDTO([
            'email' => 'john@example.com',
            'password' => 'wrong-password',
        ]);

        $this->expectException(BusinessRuleException::class);
        $this->expectExceptionMessage('Invalid credentials');

        $useCase->execute($dto);
    }

    public function testUserNotFound()
    {
        $repository = $this->createMock(UserRepositoryInterface::class);
        $authService = $this->createMock(AuthServiceInterface::class);
        $hasher = $this->createMock(Hasher::class);

        $repository->method('findByEmail')->with('nonexistent@example.com')->willReturn(null);

        $useCase = new LoginUseCase($authService, $repository, $hasher);

        $dto = new LoginRequestDTO([
            'email' => 'nonexistent@example.com',
            'password' => 'any-password',
        ]);

        $this->expectException(BusinessRuleException::class);
        $this->expectExceptionMessage('Invalid credentials');

        $useCase->execute($dto);
    }

}
