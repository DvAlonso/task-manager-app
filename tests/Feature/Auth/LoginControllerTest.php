<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    public function test_credentials_are_verified(): void
    {
        $user = $this->createUser();

        $response = $this->postJson(route('api:login'), [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
    }

    public function test_user_can_generate_tokens(): void
    {
        $user = $this->createUser();

        $response = $this->postJson(route('api:login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseCount('personal_access_tokens', 1);
    }
}
