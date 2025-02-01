<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $data = [];

        $data['customers'] = Customer::query()
            ->with(['user', 'prospect'])
            ->orderBy('created_at', 'desc')
            ->get();
        $data['users'] = User::query()
            ->orderBy('name')
            ->get();

        return Inertia::render('Customer/CustomersPage', $data);
    }

    public function search(Request $request)
    {
        $query = Customer::query()
            ->with('user');

        if ($request->has('company_name') && !empty($request->get('company_name'))) {
            $query->where('company_name', '=', $request->get('company_name'));
        }

        if ($request->has('user_id') && !empty($request->get('user_id'))) {
            $query->where('user_id', '=', $request->get('user_id'));
        }

        $results = $query->orderBy('created_at', 'desc')->get();

        return response()->json($results);
    }
}
