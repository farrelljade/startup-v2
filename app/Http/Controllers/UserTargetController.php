<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserTargetController extends Controller
{
    public function index()
    {
        $data = [];

        $data['users'] = User::query()
            ->with('targets')
            ->get();

        return Inertia::render('Admin/UserTargets', $data);
    }
}
