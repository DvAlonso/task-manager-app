<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function test_user_list_can_be_retrieved(): void
    {
        $this->setUpApiUser();

        $response = $this->getJson(route('api:users:index'));

        $response->assertStatus(200);
    }

    public function test_endpoints_are_protected_by_api_token(): void
    {
        $response = $this->getJson(route('api:users:index'));
        $response->assertStatus(401);
    }
}
