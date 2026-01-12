<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = ['user_id','action','model_type','model_id','description','old_values','new_values'];
    protected $casts = ['old_values' => 'json','new_values' => 'json'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
