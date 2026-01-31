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
            $table->boolean('is_tc')->default(false)->after('guarantee_returned')->comment('Status apakah via makelar');
            $table->integer('tc_nominal')->default(0)->after('is_tc')->comment('Besaran komisi makelar (RAHASIA - tidak tercetak di struk)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['is_tc', 'tc_nominal']);
        });
    }
};
