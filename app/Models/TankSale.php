<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TankSale extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'tank_sales';

    protected $fillable = [
        'prospect_id',
        'customer_id',
        'requested_by',
        'requested_by_email',
        'requested_at',
        'contact_name',
        'contact_email',
        'contact_phone',
        'requirement_urgent',
        'timeline',
        'fuel_type',
        'tank_type',
        'tank_size',
        'tank_location',
        'additional_requirements',
        'quotes',
        'status',
    ];

    public function prospect()
    {
        return $this->belongsTo(Prospect::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
