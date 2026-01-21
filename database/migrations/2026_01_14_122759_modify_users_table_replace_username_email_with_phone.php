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
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom phone terlebih dahulu
            $table->string('phone', 20)->after('name');
            
            // Hapus kolom username dan email
            $table->dropColumn(['username', 'email', 'email_verified_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kembalikan kolom username dan email
            $table->string('username')->unique()->after('name');
            $table->string('email')->unique()->after('username');
            $table->timestamp('email_verified_at')->nullable()->after('email');
            
            // Hapus kolom phone
            $table->dropColumn('phone');
        });
    }
};
