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
        'guest_nik',
        'guest_address',
        'check_in',
        'check_out',
        'total_price',
        'status',
        'is_ktp_held',
    ];

    protected $casts = [
        'is_ktp_held' => 'boolean',
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

    public function feedback(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Feedback::class);
    }
}
