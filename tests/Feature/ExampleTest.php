<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Dashboard should be accessible for authenticated users.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }
}
