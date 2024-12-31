<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Prospect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProspectEnquiryController extends Controller
{
    public function index($id)
    {
        $data = [];

        // First find the prospect
        $prospect = Prospect::with(['user', 'leadSource'])
            ->find($id);

        if (!$prospect) {
            abort(404);
        }

        // If prospect is a customer, get their customer record
        if ($prospect->status === 'customer') {
            $customer = Customer::where('email', $prospect->email)->first();
            if ($customer) {
                $data['orders'] = Order::where('customer_id', $customer->id)
                    ->with('product')
                    ->get();
            } else {
                $data['orders'] = collect([]);
            }
        } else {
            $data['orders'] = collect([]);
        }

        $data['prospect'] = $prospect;
        $data['products'] = Product::all();

        return Inertia::render('Prospects/ProspectProfile', $data);
    }

    public function update(Request $request, Prospect $prospect)
    {
        $validated = $request->validate([
            'phone' => ['nullable', 'string'],
        ]);

        $prospect->update($validated);

        return back();
    }
}
