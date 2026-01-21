<?php

namespace Database\Seeders;

use App\Models\Cashier;
use Illuminate\Database\Seeder;

class CashierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultCashiers = [
            'Admin Nuansa',
            'Kasir 1',
            'Kasir 2',
            'Kasir 3',
        ];

        foreach ($defaultCashiers as $name) {
            Cashier::create([
                'name' => $name,
                'is_active' => true,
            ]);
        }

        echo "✅ Cashier Seeder selesai! " . count($defaultCashiers) . " kasir ditambahkan.\n";
    }
}
