<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SicCode extends Model
{
    protected $table = 'sic_codes';

    protected $fillable = [
        'id',
        'code',
        'description'
    ];
}
