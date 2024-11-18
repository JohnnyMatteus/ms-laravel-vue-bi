<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserRequest;
use Tests\TestCase;
use Laravel\Passport\Passport;

class UserRequestLoggingTest extends TestCase
{
    public function test_user_request_is_logged()
    {
        // Criar usuário e autenticar com Passport
        $user = User::factory()->create();
        Passport::actingAs($user);

        // Fazer uma requisição autenticada
        $this->getJson('/api/dashboard')->assertStatus(200);

        // Verificar no banco de dados se a requisição foi registrada
        $this->assertDatabaseHas('user_requests', [
            'user_id' => $user->id,
            'endpoint' => 'api/dashboard',
        ]);
    }
}
