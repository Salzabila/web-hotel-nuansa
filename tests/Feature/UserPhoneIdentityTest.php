<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPhoneIdentityTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_using_phone_as_identity_without_explicit_username(): void
    {
        $user = User::create([
            'name' => 'Test Kasir',
            'phone' => '08123456789',
            'password' => 'secret123',
            'role' => 'kasir',
        ]);

        $this->assertSame('08123456789', $user->phone);
        $this->assertSame('08123456789', $user->username);
    }
}
