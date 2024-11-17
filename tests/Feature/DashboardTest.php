<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed'); // Popula o banco com as seeds.
    }

    /**
     * Testa se o endpoint do dashboard retorna os dados corretos.
     */
    public function test_dashboard_returns_correct_data()
    {
        $user = User::first();

        Passport::actingAs($user);

        $response = $this->getJson('/api/dashboard');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'actionReturns',
            'patrimonyEvolution',
            'assetDistribution',
            'sectorReturns',
            'regionGrowth',
        ]);
    }

    /**
     * Testa se o filtro por tipo de investimento funciona corretamente.
     */
    public function test_dashboard_filters_by_investment_type()
    {
        Passport::actingAs(User::factory()->create());

        $response = $this->getJson('/api/dashboard?investment_type=Renda%20Fixa');

        $response->assertStatus(200)
            ->assertJsonFragment(['label' => 'Renda Fixa']);
    }

    /**
     * Testa se o filtro por intervalo de datas funciona corretamente.
     */
    public function test_dashboard_filters_by_date_range()
    {
        Passport::actingAs(User::factory()->create());

        $response = $this->getJson('/api/dashboard?start_date=2024-01-01&end_date=2024-12-31');

        $response->assertStatus(200);
        // Adicione validações específicas para o intervalo de datas conforme necessário.
    }

    /**
     * Testa o endpoint de detalhes com dados corretos.
     */
    public function test_details_endpoint_returns_correct_data()
    {
        Passport::actingAs(User::factory()->create(), [], 'api');

        $response = $this->getJson('/api/dashboard/details/actionReturns');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['action_code', 'average_return']
        ]);
    }
    public function test_details_endpoint_returns_correct_data_without_filters()
    {
        Passport::actingAs(User::factory()->create(), [], 'api');

        $response = $this->getJson('/api/dashboard/details/actionReturns');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['action_code', 'average_return']
        ]);
    }

    public function test_details_endpoint_returns_correct_data_with_filters()
    {
        Passport::actingAs(User::factory()->create(), [], 'api');

        $filters = [
            'investment_type_id' => 2,
            'date_range' => ['2022-01-01', '2023-01-01']
        ];

        $response = $this->getJson('/api/dashboard/details/actionReturns?' . http_build_query($filters));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['action_code', 'average_return']
        ]);

        $responseData = $response->json();

        // Validar os dados retornados
        foreach ($responseData as $item) {
            $this->assertArrayHasKey('action_code', $item);
            $this->assertArrayHasKey('average_return', $item);
        }
    }


    /**
     * Testa a proteção com middleware de autenticação.
     */
    public function test_dashboard_requires_authentication()
    {
        $response = $this->getJson('/api/dashboard');

        $response->assertStatus(401); // Não autorizado.
    }
}
