<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Prospect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $data = [];

        $data['orders'] = Order::query()
            ->with(['product', 'customer', 'customer.prospect'])
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Customer/OrdersPage', $data);
    }

    public function store(Request $request, Prospect $prospect)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'ppl_sell' => ['required', 'numeric', 'min:0'],
            'ppl_cost' => ['required', 'numeric', 'min:0'],
            'vat' => ['required', 'numeric', 'min:0'],
            'nett_total' => ['required', 'numeric', 'min:0'],
            'total' => ['required', 'numeric', 'min:0'],
            'ppl_profit' => ['required', 'numeric', 'min:0'],
            'total_profit' => ['required', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($validated, $prospect) {
            // Check if prospect is already a customer
            if ($prospect->status !== 'customer') {
                // Create new customer from prospect
                $customer = Customer::create([
                    ...$prospect->only([
                        'user_id', 'company_name', 'email', 'phone',
                        'line_1', 'line_2', 'line_3', 'city',
                        'county', 'postal_code'
                    ]),
                    'prospect_id' => $prospect->id
                ]);

                $prospect->status = 'customer';
                $prospect->save();
            } else {
                $customer = Customer::where('email', $prospect->email)->first();
            }

            Order::create([
                'order_number' => 'ORD-' . str_pad(Order::count() + 1, 5, '0', STR_PAD_LEFT),
                'customer_id' => $customer->id,
                ...$validated,
            ]);
        });

        return back();
    }
}
