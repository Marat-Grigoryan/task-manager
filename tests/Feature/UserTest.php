<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user_via_api()
    {
        $userData = [
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => 'password123',
        ];

        $response = $this->withHeader('Accept', 'application/json')->post(route('user.create'), $userData);

        $response->assertStatus(200)
            ->assertJson([
                        'name' => 'user',
                        'email' => 'user@example.com',
                ]
            );

        $this->assertDatabaseHas('users', [
            'email' => 'user@example.com',
        ]);
    }
}
