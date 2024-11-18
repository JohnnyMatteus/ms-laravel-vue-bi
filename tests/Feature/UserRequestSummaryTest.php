<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserRequest;
use Tests\TestCase;
use Laravel\Passport\Passport;

class UserRequestSummaryTest extends TestCase
{
    public function test_user_requests_summary_is_returned_correctly_for_authenticated_user()
    {
        // Criar dois usuários
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Criar registros de UserRequest para os usuários
        UserRequest::create(['user_id' => $user1->id, 'endpoint' => 'api/dashboard', 'count' => 5]);
        UserRequest::create(['user_id' => $user1->id, 'endpoint' => 'api/user-requests', 'count' => 4]);
        UserRequest::create(['user_id' => $user2->id, 'endpoint' => 'api/details', 'count' => 2]);

        // Autenticar o usuário 1
        Passport::actingAs($user1);

        // Fazer a requisição para o endpoint protegido
        $response = $this->getJson('/api/user-requests');

        // Validar os dados do usuário autenticado
        $response->assertStatus(200)
            ->assertJsonFragment([
                'user' => [
                    'id' => $user1->id,
                    'name' => $user1->name,
                    'email' => $user1->email,
                ],
            ])
            ->assertJsonFragment([
                'endpoint' => 'api/dashboard',
                'total_count' => 5,
            ]);
    }

    public function test_user_requests_summary_requires_authentication()
    {
        // Fazer a requisição sem autenticação
        $response = $this->getJson('/api/user-requests');

        // Verificar se o status retornado é 401
        $response->assertStatus(401);
    }
}
