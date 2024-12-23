<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    use Hasfactory;
    protected $fillable = [
        'user_id',
        'company_name',
        'email',
        'phone',
        'line_1',
        'line_2',
        'line_3',
        'city',
        'county',
        'postal_code',
        'lead_source_id',
    ];
}
