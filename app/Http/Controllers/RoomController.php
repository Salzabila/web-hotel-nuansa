<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::orderBy('room_number')->get();
        return view('rooms.index', compact('rooms'));
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
            'status' => 'nullable|in:available,occupied,maintenance',
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
            'status' => 'nullable|in:available,occupied,maintenance',
        ]);

        $room->update($data);
        return redirect()->route('rooms.index')->with('success','Kamar diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success','Kamar dihapus.');
    }

    public function viewAll()
    {
        $rooms = Room::orderBy('room_number')->get();
        return view('rooms.all', compact('rooms'));
    }
}
