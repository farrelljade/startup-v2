<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Prospect extends Model Implements Auditable
{
    use Hasfactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'company_name',
        'email',
        'phone',
        'phone_viewed_at',
        'line_1',
        'line_2',
        'line_3',
        'city',
        'county',
        'postal_code',
        'lead_source_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leadSource()
    {
        return $this->belongsTo(LeadSource::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function tankSales()
    {
        return $this->hasMany(TankSale::class);
    }
}
