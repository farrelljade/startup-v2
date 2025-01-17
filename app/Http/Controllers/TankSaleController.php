<?php

namespace App\Http\Controllers;

use App\Http\Requests\TankSaleStoreRequest;
use App\Models\Prospect;
use App\Models\TankSale;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TankSaleController extends Controller
{
    public function index(String $id)
    {
        $prospect = Prospect::query()
            ->with(['tankSales', 'customer'])
            ->find($id);

        if ($prospect instanceof Prospect) {
            $data['prospect'] = $prospect;

            return Inertia::render('TankSales/TankSalesPage', $data);
        }
    }

    public function store(TankSaleStoreRequest $request)
    {
        $validated = $request->validated();

        if ($validated) {
//            $validated['requested_at'] = date('Y-m-d H:i:s');
            $validated['requested_at'] = now();

            TankSale::query()->create($validated);
        }
    }
}
