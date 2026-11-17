<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Hitungan admin aktif di sistem
     */
    private function countAdmins(): int
    {
        return User::where('role', 'admin')->count();
    }

    /**
     * Cek apakah user adalah satu-satunya admin
     */
    private function isLastAdmin(User $user): bool
    {
        return $user->role === 'admin' && $this->countAdmins() === 1;
    }

    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        $adminCount = $this->countAdmins();
        return view('users.index', compact('users', 'adminCount'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone',
            'password' => ['required', 'confirmed', Password::min(6)],
            'role' => 'required|in:admin,kasir',
        ]);

        // Business rule: pastikan minimal 1 admin selalu ada
        $currentAdminCount = $this->countAdmins();
        if ($currentAdminCount === 0 && $data['role'] !== 'admin') {
            return redirect()->route('users.create')
                ->with('error', 'Sistem harus memiliki minimal 1 admin. Buat user dengan role admin terlebih dahulu!');
        }

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        $isLastAdmin = $this->isLastAdmin($user);
        return view('users.edit', compact('user', 'isLastAdmin'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
            'role' => 'required|in:admin,kasir',
        ]);

        // Business rule: tidak boleh menurunkan role terakhir admin menjadi kasir
        if ($this->isLastAdmin($user) && $data['role'] === 'kasir') {
            return redirect()->route('users.edit', $user)
                ->with('error', 'Tidak bisa menurunkan role admin terakhir menjadi kasir! Sistem harus selalu memiliki minimal 1 admin.');
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        // Business rule: jangan hapus admin terakhir
        if ($this->isLastAdmin($user)) {
            return redirect()->route('users.index')
                ->with('error', 'Tidak bisa menghapus admin terakhir! Sistem harus selalu memiliki minimal 1 admin. Buat admin baru terlebih dahulu sebelum menghapus admin ini.');
        }

        // Check if user has transactions
        if ($user->transactions()->count() > 0) {
            return redirect()->route('users.index')
                ->with('error', 'User tidak bisa dihapus karena masih memiliki transaksi!');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'new_password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Password berhasil direset!');
    }
}
