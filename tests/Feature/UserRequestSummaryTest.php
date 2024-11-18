<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserRequest;
use Tests\TestCase;
use Laravel\Passport\Passport;

class UserRequestSummaryTest extends TestCase
{
    public function test_user_requests_summary_is_returned()
    {
        // Criar usuário e autenticar com Passport
        $user = User::factory()->create();
        Passport::actingAs($user);

        // Criar registros de requisições simuladas
        UserRequest::create(['user_id' => $user->id, 'endpoint' => 'api/dashboard', 'count' => 10]);
        UserRequest::create(['user_id' => $user->id, 'endpoint' => 'api/details', 'count' => 5]);

        // Fazer requisição ao endpoint de resumo
        $response = $this->getJson('/api/user-requests');

        // Validar a resposta
        $response->assertStatus(200)
            ->assertJson([
                ['endpoint' => 'api/dashboard', 'total_count' => 10],
                ['endpoint' => 'api/details', 'total_count' => 5],
            ]);
    }
}
