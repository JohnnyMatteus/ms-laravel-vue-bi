<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Limpar usuários para evitar conflitos
        User::truncate();

        // Garantir que o Personal Access Client exista
        DB::table('oauth_personal_access_clients')->insert([
            'id' => 1,
            'client_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


    }


    public function testLoginSuccess()
    {
        // Criar um usuário com os campos necessários
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('supersecret'), // Certifique-se de hashear a senha
            'email_verified_at' => now(),       // Verificar o email
            'remember_token' => Str::random(10), // Token necessário
        ]);

        // Fazer a requisição de login
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'supersecret',
        ]);

        // Verificar status e estrutura da resposta
        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }
    public function testInvalidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('supersecret'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'Invalid credentials']);
    }

    public function testUserNotFound()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'supersecret',
        ]);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'Invalid credentials']);
    }
}
