<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;
use App\Models\User;

class RegisterApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $clientRepository = app(ClientRepository::class);
        $clientRepository->createPersonalAccessClient(
            null,
            'Test Personal Access Client',
            'http://localhost'
        );
    }

    public function testRegisterSuccess()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'supersecret'
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['token']);

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function testRegisterValidationFails()
    {
        $response = $this->postJson('/api/register', [
            'email' => 'invalid-email',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors']);
    }

    public function testRegisterWithExistingEmail()
    {
        User::factory()->create(['email' => 'john@example.com']);

        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'supersecret'
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment(['email' => ['The email has already been taken.']]);
    }
}
