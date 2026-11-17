<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    /**
     * Legacy compatibility wrapper.
     * Kasir di aplikasi ini dikelola melalui tabel users dengan role = kasir.
     */
    public function index()
    {
        return redirect()->route('users.index')->with('error', 'Kasir dikelola melalui Manajemen User.');
    }

    public function store(Request $request)
    {
        return redirect()->route('users.create')->with('error', 'Buat akun kasir baru melalui form user.');
    }

    public function destroy(User $user)
    {
        return redirect()->route('users.index')->with('error', 'Hapus kasir melalui menu Manajemen User.');
    }

    /**
     * Compatibility API: return active cashier users only.
     */
    public function getActiveCashiers()
    {
        $cashiers = User::where('role', 'kasir')->orderBy('name')->get(['id', 'name']);

        return response()->json($cashiers);
    }
}
