<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    /**
     * Display list of cashiers
     */
    public function index()
    {
        $cashiers = Cashier::where('is_active', true)->orderBy('name')->get();
        return view('cashiers.index', compact('cashiers'));
    }

    /**
     * Store new cashier
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:cashiers,name',
        ]);

        Cashier::create([
            'name' => $data['name'],
            'is_active' => true,
        ]);

        return redirect()->route('cashiers.index')->with('success', '✓ Kasir "' . $data['name'] . '" berhasil ditambahkan!');
    }

    /**
     * Delete cashier (soft delete by setting is_active = false)
     */
    public function destroy(Cashier $cashier)
    {
        $cashier->update(['is_active' => false]);
        
        return redirect()->route('cashiers.index')->with('success', '✓ Kasir "' . $cashier->name . '" berhasil dihapus!');
    }

    /**
     * API endpoint to get active cashiers for dropdown
     */
    public function getActiveCashiers()
    {
        $cashiers = Cashier::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
        
        return response()->json($cashiers);
    }
}
