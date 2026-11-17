<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'invoice_code',
        'user_id',
        'room_id',
        'guest_name',
        'guest_phone',
        'guest_nik',
        'guest_address',
        'is_guest_data_complete',
        'check_in',
        'check_out',
        'duration',
        'total_price',
        'additional_charges',
        'payment_status',
        'paid_amount',
        'status',
        'is_ktp_held',
        'guarantee_type',
        'guarantee_returned',
        'is_tc',
        'tc_nominal',
        'cashier_name',
        'shift',
        'payment_method_id',
    ];

    protected $casts = [
        'is_ktp_held' => 'boolean',
        'guarantee_returned' => 'boolean',
        'is_tc' => 'boolean',
        'is_guest_data_complete' => 'boolean',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    protected $appends = [
        'checkout_urgency',
        'checkout_countdown_text',
    ];

    /**
     * Tingkat urgensi waktu checkout:
     * - 'overdue': Aktif & melewati batas waktu checkout
     * - 'imminent': Aktif & sisa waktu <= 2 jam (sangat mendekati checkout)
     * - 'today': Aktif & jadwal checkout hari ini
     * - 'upcoming': Aktif & checkout di hari mendatang
     * - 'finished': Transaksi sudah selesai
     */
    public function getCheckoutUrgencyAttribute(): string
    {
        if ($this->status !== 'active' || !$this->check_out) {
            return 'finished';
        }

        $now = \Carbon\Carbon::now();
        if ($now->greaterThan($this->check_out)) {
            return 'overdue';
        }

        $diffMinutes = $now->diffInMinutes($this->check_out, false);
        if ($diffMinutes <= 120) {
            return 'imminent';
        }

        if ($this->check_out->isToday()) {
            return 'today';
        }

        return 'upcoming';
    }

    /**
     * Teks hitung mundur / selisih waktu checkout
     */
    public function getCheckoutCountdownTextAttribute(): string
    {
        if ($this->status !== 'active' || !$this->check_out) {
            return '-';
        }

        $now = \Carbon\Carbon::now();
        $isOverdue = $now->greaterThan($this->check_out);
        $totalMinutes = abs($now->diffInMinutes($this->check_out));

        $days = floor($totalMinutes / 1440);
        $remainingMinutes = $totalMinutes % 1440;
        $hours = floor($remainingMinutes / 60);
        $minutes = $remainingMinutes % 60;

        $timeString = '';
        if ($days > 0) {
            $timeString .= "{$days} hari ";
            if ($hours > 0) {
                $timeString .= "{$hours} jam ";
            }
        } elseif ($hours > 0) {
            $timeString .= "{$hours} jam ";
            if ($minutes > 0) {
                $timeString .= "{$minutes} mnt";
            }
        } else {
            $timeString .= "{$minutes} mnt";
        }

        $timeString = trim($timeString);

        if ($isOverdue) {
            return "Lewat {$timeString}";
        }

        return "Sisa {$timeString}";
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function feedback(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Feedback::class);
    }
}
