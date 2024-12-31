<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Prospect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProspectEnquiryController extends Controller
{
    public function index(Prospect $prospect)
    {
        $data = [];

        $prospect->load(['user', 'leadSource'])->toArray();

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
