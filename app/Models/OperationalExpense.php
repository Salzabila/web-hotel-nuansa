<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationalExpense extends Model
{
    protected $table = 'operational_expenses';
    
    protected $fillable = [
        'user_id', 'category', 'description', 'amount', 'expense_date'
    ];

    protected $casts = [
        'expense_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
