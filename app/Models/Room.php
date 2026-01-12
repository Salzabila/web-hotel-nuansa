<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = ['room_number','type','price_per_night','status'];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
