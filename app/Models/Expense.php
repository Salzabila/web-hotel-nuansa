<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $table = 'expenses';
    
    protected $fillable = [
        'user_id',
        'category',
        'description',
        'amount',
        'date'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Backward-compatibility accessor & mutator for expense_date
     */
    public function getExpenseDateAttribute()
    {
        return $this->date;
    }

    public function setExpenseDateAttribute($value)
    {
        $this->attributes['date'] = $value;
    }
}
