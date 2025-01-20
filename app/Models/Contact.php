<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Contact extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'prospect_id',
        'contact_name',
        'contact_email',
        'contact_phone',
        'contact_role',
    ];

    public function prospect()
    {
        return $this->belongsTo(Prospect::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
