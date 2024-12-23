<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $data = [];

        $data['users'] = User::all();

        return Inertia::render('Admin/UsersPage', $data);
    }

    public function show(User $user)
    {
        $data = [];

        $data['user'] = $user;

        return Inertia::render('Admin/UserProfile', $data);
    }
}
