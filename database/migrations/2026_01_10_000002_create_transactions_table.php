<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code')->unique();
            $table->foreignId('room_id')->constrained()->onDelete('restrict');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('guest_name');
            $table->string('guest_nik');
            $table->text('guest_address')->nullable();
            $table->dateTime('check_in');
            $table->dateTime('check_out')->nullable();
            $table->decimal('total_price', 12, 2)->default(0);
            $table->enum('status', ['active', 'finished'])->default('active');
            $table->boolean('is_ktp_held')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
