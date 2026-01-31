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
            $table->enum('guarantee_type', ['KTP', 'SIM', 'STNK'])->default('KTP')->after('is_ktp_held');
            $table->boolean('guarantee_returned')->default(false)->after('guarantee_type')->comment('Sudah dikembalikan atau belum');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['guarantee_type', 'guarantee_returned']);
        });
    }
};
