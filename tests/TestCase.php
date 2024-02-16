<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, LazilyRefreshDatabase;

    /**
     * Create an user for a test.
     */
    public function createUser(): User
    {
        return User::factory()->create();
    }

    /**
     * Crete an user and use it for requests.
     */
    public function setUpApiUser(): User
    {
        return Sanctum::actingAs($this->createUser());
    }
}
