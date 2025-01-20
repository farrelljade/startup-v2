<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Address extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'line_1',
        'line_2',
        'line_3',
        'city',
        'county',
        'postal_code',
    ];

    public function prospect()
    {
        return $this->belongsTo(Prospect::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
