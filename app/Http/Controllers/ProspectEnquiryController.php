<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Prospect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProspectEnquiryController extends Controller
{
    public function index($id)
    {
        $data = [];

        // Try to find as customer first, then as prospect if not found
        $company = Customer::with(['user'])
            ->find($id) ??
            Prospect::with(['user', 'leadSource'])
                ->find($id);

        if (!$company) {
            abort(404);
        }

        $data['prospect'] = $company;
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
