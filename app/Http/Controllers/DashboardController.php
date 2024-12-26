<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $user->load('prospects');

        return Inertia::render('Dashboard', [
            'user' => $user
        ]);
    }
}
