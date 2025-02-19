<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user login
     */
    public function test_user_login(): void
    {
        // seed test user
        $this->seed(DatabaseSeeder::class);

        $response = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'Password@321',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['access_token']);
    }

    /**
     * Test user logout
     */
    public function test_user_logout(): void
    {
        // seed test user
        $this->seed(DatabaseSeeder::class);

        // login
        $response = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'Password@321',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['access_token']);

        $token = $response->json()['access_token'];

        // logout
        $response = $this->withHeaders([
                        'Authorization' => "Bearer {$token}",
                    ])->post('/api/logout');

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['message'])
            ->assertJson(['message' => 'logged out']);
    }
}
