<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('additional_charges', 12, 2)->default(0)->after('total_price');
            $table->enum('payment_status', ['paid', 'unpaid', 'partial'])->default('unpaid')->after('status');
            $table->decimal('paid_amount', 12, 2)->default(0)->after('payment_status');
            $table->integer('duration')->default(1)->after('check_out');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['additional_charges', 'payment_status', 'paid_amount', 'duration']);
        });
    }
};
