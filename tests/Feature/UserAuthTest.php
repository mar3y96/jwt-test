<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserAuthTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function test_user_registration()
    {
        $response = $this->postJson('/api/user/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password@Pas1234',
            'password_confirmation' => 'password@Pas1234',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'User created successfully',
            ]);
    }

    public function testUserLogin()
    {

        $credentials = [
            'email' => 'mar3y96@gmail.com',
            'password' => 'password@A123'
        ];
        $user = User::factory()->create($credentials);


        $response = $this->postJson('/api/user/login', $credentials);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user',
                'authorisation',
                'status',
            ]);
    }
}
