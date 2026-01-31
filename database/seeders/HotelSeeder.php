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

        // 32 Kamar Hotel Nuansa
        $rooms = [
            ['room_number' => '01', 'type' => 'Deluxe (AC)', 'price_per_night' => 180000, 'status' => 'available'],
            ['room_number' => '02', 'type' => 'Deluxe (AC)', 'price_per_night' => 180000, 'status' => 'available'],
            ['room_number' => '03', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '04', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '05', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '06', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '07', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '08', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '09', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '10', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '11', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '12', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '13', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '14', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '15', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '16', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '17', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '18', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '19', 'type' => 'Standard (Kipas)', 'price_per_night' => 120000, 'status' => 'available'],
            ['room_number' => '20', 'type' => 'Deluxe (AC)', 'price_per_night' => 180000, 'status' => 'available'],
            ['room_number' => '21', 'type' => 'Deluxe (AC)', 'price_per_night' => 180000, 'status' => 'available'],
            ['room_number' => '22', 'type' => 'Deluxe (AC)', 'price_per_night' => 180000, 'status' => 'available'],
            ['room_number' => '23', 'type' => 'Suite (AC + TV)', 'price_per_night' => 200000, 'status' => 'available'],
            ['room_number' => '24', 'type' => 'Suite (AC + TV)', 'price_per_night' => 200000, 'status' => 'available'],
            ['room_number' => '25', 'type' => 'Suite (AC + TV)', 'price_per_night' => 200000, 'status' => 'available'],
            ['room_number' => '26', 'type' => 'Standard Plus (Kipas)', 'price_per_night' => 130000, 'status' => 'available'],
            ['room_number' => '27', 'type' => 'Standard Plus (Kipas)', 'price_per_night' => 130000, 'status' => 'available'],
            ['room_number' => '28', 'type' => 'Standard Plus (Kipas)', 'price_per_night' => 130000, 'status' => 'available'],
            ['room_number' => '29', 'type' => 'Standard Plus (Kipas)', 'price_per_night' => 130000, 'status' => 'available'],
            ['room_number' => '30', 'type' => 'Suite (AC + TV)', 'price_per_night' => 200000, 'status' => 'available'],
            ['room_number' => '31', 'type' => 'Standard Plus (Kipas)', 'price_per_night' => 130000, 'status' => 'available'],
            ['room_number' => '32', 'type' => 'Standard Plus (Kipas)', 'price_per_night' => 130000, 'status' => 'available'],
        ];

        foreach ($rooms as $roomData) {
            Room::create($roomData);
        }

        // Create sample transaction for room 03
        Transaction::create([
            'invoice_code' => 'INV-' . now()->format('d-m-Y') . '-001',
            'user_id' => $kasir->id,
            'room_id' => 3, // Room 03
            'guest_name' => 'Budi Santoso',
            'guest_nik' => '3271234567890123',
            'guest_address' => 'Jl. Gatot Subroto No. 1, Bandung',
            'check_in' => now(),
            'check_out' => now()->addDays(2),
            'total_price' => 240000,
            'status' => 'active',
            'is_ktp_held' => true,
            'guarantee_type' => 'KTP',
            'guarantee_returned' => false,
            'is_tc' => false,
            'tc_nominal' => 0,
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
