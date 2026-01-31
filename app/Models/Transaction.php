<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
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
