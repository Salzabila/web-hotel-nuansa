<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::orderBy('room_number')->get();
        
        // Summary data untuk cards
        $summary = [
            'total' => Room::count(),
            'available' => Room::where('status', 'available')->count(),
            'occupied' => Room::where('status', 'occupied')->count(),
            'maintenance' => Room::where('status', 'dirty')->count()
        ];
        
        return view('rooms.index', compact('rooms', 'summary'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_number' => 'required|unique:rooms,room_number',
            'type' => 'required|in:Standard (Kipas),Deluxe (AC)',
            'price_per_night' => 'required|numeric|min:0',
            'status' => 'nullable|in:available,occupied,maintenance,dirty',
        ]);
        
        Room::create($data);
        return redirect()->route('rooms.index')->with('success','Kamar nomor ' . $data['room_number'] . ' berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'price_per_night' => 'required|numeric|min:0',
            'status' => 'nullable|in:available,occupied,maintenance,dirty',
        ]);

        $room->update($data);
        return redirect()->route('rooms.index')->with('success','Kamar diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success','Kamar dihapus.');
    }

    /**
     * Mark a dirty room as clean and available
     * Accessible by both Admin and Kasir
     */
    public function markAsClean($id)
    {
        $room = Room::findOrFail($id);

        if ($room->status !== 'dirty') {
            return back()->with('error', 'Hanya kamar dengan status KOTOR yang bisa ditandai bersih.');
        }

        $room->status = 'available';
        $room->save();

        return back()->with('success', "✓ Kamar {$room->room_number} telah dibersihkan dan siap dijual kembali.");
    }
}
