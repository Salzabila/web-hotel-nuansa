<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Transaction;
use App\Models\OperationalExpense;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Admin User
        $admin = User::create([
            'name' => 'Admin Nuansa',
            'phone' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // 1 Kasir User
        $kasir = User::create([
            'name' => 'Kasir Nuansa',
            'phone' => 'kasir',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir',
        ]);

        // 5 Dummy Rooms
        $rooms = [
            ['room_number' => '101', 'type' => 'Standard (Kipas)', 'price_per_night' => 150000, 'status' => 'available'],
            ['room_number' => '102', 'type' => 'Standard (Kipas)', 'price_per_night' => 150000, 'status' => 'available'],
            ['room_number' => '103', 'type' => 'Standard (Kipas)', 'price_per_night' => 150000, 'status' => 'occupied'],
            ['room_number' => '201', 'type' => 'Deluxe (AC)', 'price_per_night' => 250000, 'status' => 'available'],
            ['room_number' => '202', 'type' => 'Deluxe (AC)', 'price_per_night' => 250000, 'status' => 'maintenance'],
        ];

        foreach ($rooms as $roomData) {
            Room::create($roomData);
        }

        // Create sample transaction for occupied room
        Transaction::create([
            'invoice_code' => 'INV-' . now()->format('d-m-Y') . '-001',
            'user_id' => $kasir->id,
            'room_id' => 3, // Room 103
            'guest_name' => 'Budi Santoso',
            'guest_nik' => '3271234567890123',
            'guest_address' => 'Jl. Gatot Subroto No. 1, Bandung',
            'check_in' => now(),
            'check_out' => now()->addDays(2),
            'total_price' => 300000,
            'status' => 'active',
            'is_ktp_held' => true,
        ]);

        // Create sample expenses
        OperationalExpense::create([
            'user_id' => $admin->id,
            'category' => 'utilities',
            'description' => 'Tagihan Listrik Bulan Januari',
            'amount' => 2000000,
            'expense_date' => now()->toDateString(),
        ]);

        OperationalExpense::create([
            'user_id' => $admin->id,
            'category' => 'utilities',
            'description' => 'Tagihan Air Bulan Januari',
            'amount' => 500000,
            'expense_date' => now()->toDateString(),
        ]);

        OperationalExpense::create([
            'user_id' => $admin->id,
            'category' => 'maintenance',
            'description' => 'Perbaikan Pintu Kamar 105',
            'amount' => 350000,
            'expense_date' => now()->subDays(1)->toDateString(),
        ]);

        OperationalExpense::create([
            'user_id' => $admin->id,
            'category' => 'supplies',
            'description' => 'Pembelian Handuk dan Sprei',
            'amount' => 1200000,
            'expense_date' => now()->subDays(2)->toDateString(),
        ]);

        $this->command->info('✅ Hotel Seeder selesai!');
        $this->command->info('Admin: phone=admin | password=admin123');
        $this->command->info('Kasir: phone=kasir | password=kasir123');
    }
}
