<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Transaction;
use App\Models\OperationalExpense;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users
        $admin = User::create([
            'name' => 'Admin Hotel',
            'username' => 'admin',
            'email' => 'admin@hotelnuansa.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $kasir = User::create([
            'name' => 'Kasir 1',
            'username' => 'kasir1',
            'email' => 'kasir1@hotelnuansa.com',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
        ]);

        // Create rooms
        $roomData = [
            ['room_number' => '101', 'type' => 'Standard (Kipas)', 'price_per_night' => 150000, 'status' => 'available'],
            ['room_number' => '102', 'type' => 'Standard (Kipas)', 'price_per_night' => 150000, 'status' => 'available'],
            ['room_number' => '103', 'type' => 'Standard (Kipas)', 'price_per_night' => 150000, 'status' => 'occupied'],
            ['room_number' => '104', 'type' => 'Standard (Kipas)', 'price_per_night' => 150000, 'status' => 'available'],
            ['room_number' => '201', 'type' => 'Deluxe (AC)', 'price_per_night' => 250000, 'status' => 'available'],
            ['room_number' => '202', 'type' => 'Deluxe (AC)', 'price_per_night' => 250000, 'status' => 'occupied'],
            ['room_number' => '203', 'type' => 'Deluxe (AC)', 'price_per_night' => 250000, 'status' => 'available'],
            ['room_number' => '204', 'type' => 'Deluxe (AC)', 'price_per_night' => 250000, 'status' => 'maintenance'],
        ];

        $rooms = [];
        foreach ($roomData as $data) {
            $rooms[] = Room::create($data);
        }

        // Create sample transactions (some finished, some active)
        // Finished transactions
        for ($i = 1; $i <= 5; $i++) {
            $checkInDate = now()->subDays(rand(5, 30));
            $nights = rand(1, 3);
            $checkOutDate = $checkInDate->copy()->addDays($nights);

            Transaction::create([
                'room_id' => $rooms[rand(0, count($rooms) - 1)]->id,
                'user_id' => $kasir->id,
                'invoice_code' => 'INV-' . $checkInDate->format('Ymd') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'guest_name' => 'Pelanggan ' . $i,
                'guest_nik' => '327' . rand(1000000, 9999999),
                'guest_address' => 'Jalan Raya ' . $i . ', Kota Bandung',
                'check_in' => $checkInDate,
                'check_out_plan' => $checkOutDate,
                'check_out_actual' => $checkOutDate,
                'total_price' => $rooms[rand(0, count($rooms) - 1)]->price_per_night * $nights,
                'status' => 'finished',
                'is_ktp_held' => false,
            ]);
        }

        // Active transactions
        $activeCheckIn = now();
        $activeCheckOut = $activeCheckIn->copy()->addDays(2);

        Transaction::create([
            'room_id' => 3, // Room 103 (occupied)
            'user_id' => $kasir->id,
            'invoice_code' => 'INV-' . now()->format('Ymd') . '-001',
            'guest_name' => 'Budi Santoso',
            'guest_nik' => '3271234567890123',
            'guest_address' => 'Jalan Gatot Subroto No. 1, Bandung',
            'check_in' => $activeCheckIn,
            'check_out_plan' => $activeCheckOut,
            'check_out_actual' => null,
            'total_price' => 300000,
            'status' => 'active',
            'is_ktp_held' => true,
        ]);

        Transaction::create([
            'room_id' => 6, // Room 202 (occupied)
            'user_id' => $kasir->id,
            'invoice_code' => 'INV-' . now()->format('Ymd') . '-002',
            'guest_name' => 'Siti Nurhaliza',
            'guest_nik' => '3272345678901234',
            'guest_address' => 'Jalan Merdeka No. 42, Bandung',
            'check_in' => $activeCheckIn->copy()->subHours(5),
            'check_out_plan' => $activeCheckOut->copy()->addDays(1),
            'check_out_actual' => null,
            'total_price' => 500000,
            'status' => 'active',
            'is_ktp_held' => false,
        ]);

        // Create operational expenses
        $expenseCategories = ['maintenance', 'utilities', 'supplies', 'other'];
        $descriptions = [
            'maintenance' => ['Perbaikan AC kamar 201', 'Penggantian lampu di lobby', 'Service lift'],
            'utilities' => ['Listrik Bulan ini', 'Air bersih', 'Internet bulanan'],
            'supplies' => ['Pembersih lantai', 'Sabun tangan', 'Kertas toilet'],
            'other' => ['Biaya kebersihan', 'Bonus karyawan', 'Konsumsi rapat'],
        ];

        for ($i = 0; $i < 10; $i++) {
            $category = $expenseCategories[rand(0, count($expenseCategories) - 1)];
            $descriptions_by_cat = $descriptions[$category];

            OperationalExpense::create([
                'user_id' => $admin->id,
                'category' => $category,
                'description' => $descriptions_by_cat[rand(0, count($descriptions_by_cat) - 1)],
                'amount' => rand(50000, 500000),
                'expense_date' => now()->subDays(rand(0, 30))->format('Y-m-d'),
            ]);
        }

        $this->command->info('Test data seeded successfully!');
        $this->command->info('Admin Username: admin | Password: password123');
        $this->command->info('Kasir Username: kasir1 | Password: password123');
    }
}
