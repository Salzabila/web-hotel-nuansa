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
        // Update enum to include 'dirty' status
        Schema::table('rooms', function (Blueprint $table) {
            $table->enum('status', ['available', 'occupied', 'maintenance', 'dirty'])
                ->default('available')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->enum('status', ['available', 'occupied', 'maintenance'])
                ->default('available')
                ->change();
        });
    }
};
