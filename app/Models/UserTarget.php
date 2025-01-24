<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class UserTarget extends Model Implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'target_id',
        'target_value',
        'current_value',
        'start_date',
        'end_date',
        'achieved'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function target(): BelongsTo
    {
        return $this->belongsTo(Target::class);
    }
}
