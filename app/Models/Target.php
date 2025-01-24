<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function userTargets(): HasMany
    {
        return $this->hasMany(UserTarget::class);
    }
}
