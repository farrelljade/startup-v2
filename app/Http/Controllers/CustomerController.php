<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $data = [];

        $data['customers'] = Customer::query()
            ->with('user')
            ->get();

        return Inertia::render('Customer/CustomersPage', $data);
    }
}
