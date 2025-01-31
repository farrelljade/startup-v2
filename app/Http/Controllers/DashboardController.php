<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Prospect;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function show(User $user = null)
    {
        $data = [];

        if (array_key_exists('impersonate', $_COOKIE) && !empty($_COOKIE['impersonate'])) {
            $data['user'] = User::select(['id', 'name', 'email', 'is_admin'])
                ->find($_COOKIE['impersonate']);
        } else {
            $data['user'] = $user ?? Auth::user();
        }

        $data['userProfitThisMonth'] = Order::query()
            ->whereHas('customer', function ($query) use ($data) {
                $query->where('user_id', $data['user']->id);
            })
            ->whereMonth('created_at', now()->month)
            ->sum('total_profit');
        $data['prospectsToCustomers'] = Prospect::query()
            ->join('customers', 'prospects.id', '=', 'customers.prospect_id')
            ->where('prospects.user_id', $data['user']->id)
            ->where('prospects.status', 'customer')
            ->whereMonth('customers.created_at', now()->month)
            ->count();
        $data['userTargets'] = User::query()
            ->with(['targets' => function($query) {
                $query->where('start_date', '<=', now())
                    ->where('end_date', '>=', now()->month)
                    ->with('target');
            }])
            ->find($data['user']->id)
            ->targets;
        $data['prospects'] = $data['user']->prospects()
            ->where('status', 'prospect')
            ->get();
        $data['customers'] = $data['user']->prospects()
            ->with('user')
            ->where('status', 'customer')
            ->get();
        $data['userOrders'] = Order::query()
            ->whereHas('customer', function ($query) use ($data) {
                $query->where('user_id', $data['user']->id);
            })
            ->with(['product', 'customer.user' => function ($query) {
                $query->select('id', 'name');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('User/Dashboard', $data);
    }
}
