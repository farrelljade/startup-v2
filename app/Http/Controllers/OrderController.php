<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Prospect;
use App\Services\ProspectConversionService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected ProspectConversionService $conversionService;

    public function __construct(ProspectConversionService $conversionService)
    {
        $this->conversionService = $conversionService;
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

        // Create the order first
        $order = Order::create([
            'order_number' => 'ORD-' . str_pad(Order::count() + 1, 5, '0', STR_PAD_LEFT),
            ...$validated,
        ]);

        $this->conversionService->convertToCustomer($prospect, $order);
    }
}
