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
            // Ubah guarantee_type menjadi nullable untuk Express Check-in
            $table->enum('guarantee_type', ['KTP', 'SIM', 'STNK'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Kembalikan ke NOT NULL
            $table->enum('guarantee_type', ['KTP', 'SIM', 'STNK'])->nullable(false)->change();
        });
    }
};
