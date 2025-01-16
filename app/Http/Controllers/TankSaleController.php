<?php

namespace App\Http\Controllers;

use App\Models\Prospect;
use App\Models\TankSale;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TankSaleController extends Controller
{
    public function index(String $id)
    {
        $prospect = Prospect::query()
            ->with('tankSales')
            ->find($id);

        if ($prospect instanceof Prospect) {
            $data['prospect'] = $prospect;

            return Inertia::render('TankSales/TankSalesPage', $data);
        }
    }
}
