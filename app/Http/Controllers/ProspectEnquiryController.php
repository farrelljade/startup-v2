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
        $prospect = Prospect::with(['user', 'leadSource', 'tankSales'])
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
                    ->orderBy('created_at', 'desc')
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
            'phone' => ['nullable'],
            'phone_viewed_at' => ['nullable', 'date'],
        ]);

        if (isset($validated['phone_viewed_at'])) {
            $validated['phone_viewed_at'] = now();
        }

        $prospect->update($validated);

        return response()->json(['message' => 'Prospect updated successfully!']);
    }
}
