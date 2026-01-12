<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            if (Schema::hasColumn('rooms', 'price')) {
                $table->renameColumn('price', 'price_per_night');
            }
            if (Schema::hasColumn('rooms', 'type')) {
                // Drop old type if it exists, will re-add
                $table->dropColumn('type');
            }
        });
        
        Schema::table('rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('rooms', 'type')) {
                $table->enum('type', ['Standard (Kipas)', 'Deluxe (AC)'])->after('room_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            if (Schema::hasColumn('rooms', 'price_per_night')) {
                $table->renameColumn('price_per_night', 'price');
            }
        });
    }
};
