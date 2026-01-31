<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'bank_name' => 'Cash',
                'account_number' => null,
                'is_active' => true
            ],
            [
                'bank_name' => 'Transfer BCA',
                'account_number' => '1234567890',
                'is_active' => true
            ],
            [
                'bank_name' => 'Transfer Mandiri',
                'account_number' => '9876543210',
                'is_active' => true
            ],
            [
                'bank_name' => 'QRIS',
                'account_number' => null,
                'is_active' => true
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }
    }
}
