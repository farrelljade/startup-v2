<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'product_id',
        'order_number',
        'quantity',
        'ppl_sell',
        'vat',
        'nett_total',
        'total',
        'ppl_cost',
        'ppl_profit',
        'total_profit',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
