<?php

namespace App\Console\Commands;

use App\Models\Room;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupOrphanTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-orphan-transactions {--fix : Actually fix the issues} {--days=7 : Days threshold for old transactions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup orphan transactions: find and fix data inconsistencies between rooms and transactions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Scanning for orphan transactions...');
        $fix = $this->option('fix');
        $days = (int) $this->option('days');
        
        // Issue 1: Available rooms with active transactions
        $this->line("\n📋 Issue 1: Rooms with status 'available' but have active transactions");
        $orphanAvailable = Room::where('status', 'available')
            ->whereHas('transactions', function($q) {
                $q->where('status', 'active');
            })
            ->with('transactions')
            ->get();
        
        if ($orphanAvailable->count() > 0) {
            $this->warn("Found {$orphanAvailable->count()} room(s):");
            foreach ($orphanAvailable as $room) {
                $activeTx = $room->transactions()->where('status', 'active')->get();
                foreach ($activeTx as $tx) {
                    $this->line("  - Room {$room->room_number}: Active transaction ID {$tx->id} (created {$tx->created_at})");
                    
                    if ($fix) {
                        // Soft delete orphan transaction
                        $tx->delete();
                        $this->info("    ✓ Soft deleted transaction {$tx->id}");
                    }
                }
            }
        } else {
            $this->info('✓ No issues found');
        }
        
        // Issue 2: Very old active transactions (> X days)
        $this->line("\n📋 Issue 2: Active transactions older than {$days} days");
        $oldDate = Carbon::now()->subDays($days);
        $oldTransactions = Transaction::where('status', 'active')
            ->where('created_at', '<', $oldDate)
            ->with('room')
            ->get();
        
        if ($oldTransactions->count() > 0) {
            $this->warn("Found {$oldTransactions->count()} transaction(s):");
            foreach ($oldTransactions as $tx) {
                $this->line("  - Transaction {$tx->id}: Room {$tx->room->room_number} (created {$tx->created_at})");
                
                if ($fix) {
                    // Mark as finished (assume guest checked out)
                    $tx->status = 'finished';
                    $tx->check_out = $tx->check_out ?? $tx->created_at->copy()->addDays($tx->duration ?? 1);
                    $tx->save();
                    
                    // Update room status to dirty (needs cleaning)
                    if ($tx->room->status === 'occupied') {
                        $tx->room->status = 'dirty';
                        $tx->room->save();
                    }
                    
                    $this->info("    ✓ Marked transaction {$tx->id} as finished, room set to dirty");
                }
            }
        } else {
            $this->info('✓ No issues found');
        }
        
        // Issue 3: Occupied rooms without active transactions
        $this->line("\n📋 Issue 3: Rooms with status 'occupied' but no active transactions");
        $orphanOccupied = Room::where('status', 'occupied')
            ->whereDoesntHave('transactions', function($q) {
                $q->where('status', 'active');
            })
            ->get();
        
        if ($orphanOccupied->count() > 0) {
            $this->warn("Found {$orphanOccupied->count()} room(s):");
            foreach ($orphanOccupied as $room) {
                $lastTx = $room->transactions()->latest()->first();
                $this->line("  - Room {$room->room_number} (last tx: {$lastTx?->status ?? 'none'})");
                
                if ($fix) {
                    $room->status = 'dirty';
                    $room->save();
                    $this->info("    ✓ Set room {$room->room_number} to dirty (needs cleaning)");
                }
            }
        } else {
            $this->info('✓ No issues found');
        }
        
        if (!$fix) {
            $this->line("\n💡 Run with --fix flag to apply fixes: php artisan app:cleanup-orphan-transactions --fix");
        }
        
        $this->info("\n✅ Cleanup scan complete!");
    }
}
