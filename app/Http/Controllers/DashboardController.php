<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function show(User $user = null)
    {
        $data = [];

        $data['user'] = $user ?? Auth::user();
        $data['prospects'] = $data['user']->prospects()
            ->where('status', 'prospect')
            ->get();
        $data['customers'] = $data['user']->prospects()
            ->with('user')
            ->where('status', 'customer')
            ->get();

        return Inertia::render('Dashboard', $data);
    }
}
