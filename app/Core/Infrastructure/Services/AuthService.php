<?php

namespace App\Core\Infrastructure\Services;

use App\Core\Domain\Services\AuthServiceInterface;
use App\Core\Domain\Entities\User as DomainUser;
use App\Models\User as EloquentUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{
    /**
     * Gera um token para um usuário.
     */
    public function generateToken(DomainUser $user): string
    {
        $eloquentUser = EloquentUser::where('email', $user->getEmail())->first();

        if (!$eloquentUser) {
            throw new \Exception('User not found');
        }

        // Criação do token pessoal via Passport
        $token = $eloquentUser->createToken('API Token');

        return $token->accessToken; // Utilize `accessToken`
    }

    /**
     * Verifica se a senha fornecida é válida.
     */
    public function checkPassword(DomainUser $user, string $password): bool
    {
        $eloquentUser = EloquentUser::where('email', $user->getEmail())->first();

        if (!$eloquentUser) {
            return false;
        }

        return Hash::check($password, $eloquentUser->password);
    }

    /**
     * Retorna o usuário autenticado.
     */
    public function getAuthenticatedUser(): ?DomainUser
    {
        $eloquentUser = Auth::user();

        if (!$eloquentUser) {
            return null;
        }

        return new DomainUser(
            $eloquentUser->name,
            $eloquentUser->email,
            $eloquentUser->password
        );
    }

    /**
     * Faz o logout do usuário autenticado.
     */
    public function logout(): void
    {
        $user = Auth::user();

        if ($user) {
            $user->tokens()->delete(); // Revogar todos os tokens
        }
    }
}
