<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Prospect;
use Illuminate\Support\Facades\DB;

class ProspectConversionService
{
    public function convertToCustomer(Prospect $prospect, Order $order)
    {
        DB::transaction(function () use ($prospect, $order) {
            // Create new customer from prospect data
            $customer = Customer::create([
                'user_id' => $prospect->user_id,
                'company_name' => $prospect->company_name,
                'email' => $prospect->email,
                'phone' => $prospect->phone,
                'line_1' => $prospect->line_1,
                'line_2' => $prospect->line_2,
                'line_3' => $prospect->line_3,
                'city' => $prospect->city,
                'county' => $prospect->county,
                'postal_code' => $prospect->postal_code,
            ]);

            // Associate order with new customer
            $order->customer_id = $customer->id;
            $order->save();

            // Update prospect status
            $prospect->status = 'customer';
            $prospect->save();
        });
    }
}
