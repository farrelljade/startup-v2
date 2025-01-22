<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Target extends Model Implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'type'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_targets')
            ->withPivot('target_value', 'current_value', 'start_date', 'end_date', 'achieved')
            ->withTimestamps();
    }
}
