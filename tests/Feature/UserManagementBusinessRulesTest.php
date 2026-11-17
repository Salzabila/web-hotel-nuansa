<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementBusinessRulesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test: Tidak boleh menurunkan role terakhir admin menjadi kasir
     */
    public function test_cannot_downgrade_last_admin_to_kasir(): void
    {
        // Get the last admin
        $admin = User::where('role', 'admin')->first();

        // Try to downgrade to kasir
        $response = $this->actingAs($admin)
            ->put(route('users.update', $admin), [
                'name' => $admin->name,
                'phone' => $admin->phone,
                'role' => 'kasir',
            ]);

        // Should fail
        $response->assertRedirect(route('users.edit', $admin));
        $response->assertSessionHas('error');
        $this->assertStringContainsString('admin terakhir', session('error'));
        
        // Verify user still has admin role
        $admin->refresh();
        $this->assertSame('admin', $admin->role);
    }

    /**
     * Test: Tidak boleh menghapus admin terakhir
     */
    public function test_cannot_delete_last_admin(): void
    {
        $admin = User::where('role', 'admin')->first();
        $adminUser = User::where('role', 'admin')->where('id', '!=', $admin->id)->first() ?? $admin;

        $response = $this->actingAs($adminUser)
            ->delete(route('users.destroy', $admin));

        // Should redirect to users.index with error
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('error');
        $this->assertStringContainsString('admin terakhir', session('error'));
        
        // Verify admin still exists
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    /**
     * Test: Sistem harus minimal memiliki 1 admin
     */
    public function test_system_must_have_at_least_one_admin(): void
    {
        $admin = User::where('role', 'admin')->first();

        // Delete all admins except one
        $admins = User::where('role', 'admin')->get();
        foreach ($admins->skip(1) as $adminToDelete) {
            $adminToDelete->delete();
        }

        // Try to create a new user with only kasir role (should fail)
        $response = $this->actingAs($admin)
            ->post(route('users.store'), [
                'name' => 'New User',
                'phone' => '081234567890',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'role' => 'kasir',
            ]);

        // Should redirect back with error
        $response->assertRedirect(route('users.create'));
        $response->assertSessionHas('error');
        $this->assertStringContainsString('minimal 1 admin', session('error'));
    }

    /**
     * Test: Bisa menurunkan admin jika ada admin lain
     */
    public function test_can_downgrade_admin_if_other_admin_exists(): void
    {
        // Create second admin
        $admin2 = User::create([
            'name' => 'Admin Kedua',
            'phone' => '081111111111',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // Get first admin
        $admin = User::where('role', 'admin')->where('id', '!=', $admin2->id)->first();

        // Should be able to downgrade
        $response = $this->actingAs($admin)
            ->put(route('users.update', $admin), [
                'name' => $admin->name,
                'phone' => $admin->phone,
                'role' => 'kasir',
            ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'User berhasil diupdate!');
        
        // Verify user now has kasir role
        $admin->refresh();
        $this->assertSame('kasir', $admin->role);
    }

    /**
     * Test: Bisa menghapus admin jika ada admin lain
     */
    public function test_can_delete_admin_if_other_admin_exists(): void
    {
        // Create second admin
        $admin2 = User::create([
            'name' => 'Admin Kedua',
            'phone' => '081111111111',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // Get first admin
        $admin = User::where('role', 'admin')->where('id', '!=', $admin2->id)->first();

        // Should be able to delete
        $response = $this->actingAs($admin2)
            ->delete(route('users.destroy', $admin));

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'User berhasil dihapus!');
        
        // Verify user is deleted
        $this->assertDatabaseMissing('users', ['id' => $admin->id]);
    }

    /**
     * Test: Tidak boleh menghapus akun sendiri
     */
    public function test_cannot_delete_own_account(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)
            ->delete(route('users.destroy', $admin));

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('error', 'Anda tidak bisa menghapus akun sendiri!');
        
        // Verify user still exists
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    /**
     * Test: Bisa membuat user dengan role admin
     */
    public function test_can_create_user_with_admin_role(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)
            ->post(route('users.store'), [
                'name' => 'Admin Baru',
                'phone' => '082222222222',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'role' => 'admin',
            ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'User berhasil ditambahkan!');
        
        $this->assertDatabaseHas('users', [
            'name' => 'Admin Baru',
            'phone' => '082222222222',
            'role' => 'admin',
        ]);
    }

    /**
     * Test: Tidak boleh duplikat phone
     */
    public function test_cannot_create_user_with_duplicate_phone(): void
    {
        $admin = User::where('role', 'admin')->first();
        $existing = User::where('id', '!=', $admin->id)->first();

        $response = $this->actingAs($admin)
            ->post(route('users.store'), [
                'name' => 'Duplicate Phone',
                'phone' => $existing->phone,
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'role' => 'kasir',
            ]);

        $response->assertSessionHasErrors('phone');
    }
}
