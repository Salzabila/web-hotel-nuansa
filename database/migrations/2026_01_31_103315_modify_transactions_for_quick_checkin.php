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
            // Ubah kolom menjadi nullable untuk Quick Check-in
            $table->string('guest_nik', 50)->nullable()->change();
            $table->string('guest_phone', 20)->nullable()->change();
            $table->text('guest_address')->nullable()->change();
            
            // Tambah kolom flag untuk tracking kelengkapan data tamu
            $table->boolean('is_guest_data_complete')->default(false)->after('guest_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Kembalikan ke NOT NULL (hati-hati jika ada data NULL)
            $table->string('guest_nik', 50)->nullable(false)->change();
            $table->string('guest_phone', 20)->nullable(false)->change();
            $table->text('guest_address')->nullable(false)->change();
            
            // Hapus kolom flag
            $table->dropColumn('is_guest_data_complete');
        });
    }
};
