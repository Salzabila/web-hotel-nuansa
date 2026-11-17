<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Add user_id to expenses if not exists
        if (Schema::hasTable('expenses') && !Schema::hasColumn('expenses', 'user_id')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            });
        }

        // Migrate records from operational_expenses to expenses
        if (Schema::hasTable('operational_expenses') && Schema::hasTable('expenses')) {
            $opExpenses = DB::table('operational_expenses')->get();
            foreach ($opExpenses as $op) {
                // Check if already in expenses by description, amount and date
                $dateVal = substr($op->expense_date, 0, 10);
                $exists = DB::table('expenses')
                    ->where('description', $op->description)
                    ->where('amount', $op->amount)
                    ->where('date', $dateVal)
                    ->exists();

                if (!$exists) {
                    DB::table('expenses')->insert([
                        'user_id' => $op->user_id ?? 1,
                        'category' => $op->category,
                        'description' => $op->description,
                        'amount' => $op->amount,
                        'date' => $dateVal,
                        'created_at' => $op->created_at ?? now(),
                        'updated_at' => $op->updated_at ?? now(),
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('expenses', 'user_id')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }
    }
};
