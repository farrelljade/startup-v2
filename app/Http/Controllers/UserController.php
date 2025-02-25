<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $data = [];

        $data['users'] = User::query()
            ->with('manager:id,name')
            ->select(['id', 'name', 'email', 'manager_id', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Admin/UsersPage', $data);
    }

    public function show(User $user)
    {
        $data = [];

        $data['user'] = $user;
        $data['users'] = User::query()
            ->with('manager:id,name')
            ->select(['id', 'name', 'email', 'manager_id', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->get();
        $data['availablePermissions'] = Permission::all();

        return Inertia::render('Admin/UserProfile', $data);
    }

    public function update(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'manager_id' => ['nullable', 'exists:users,id']
        ]);

        $user->update($validated);

        return back();
    }

    public function updatePermissions(Request $request, User $user)
    {
        // Get the permissions array
        $permissions = $request->permissions;
        if (is_array($permissions) && isset($permissions[0]['permissions'])) {
            $permissions = $permissions[0]['permissions'];
        }

        // If permissions is empty or null, sync with empty array
        if (empty($permissions)) {
            $user->permissions()->sync([]);
            return back();
        }

        $permissionIds = Permission::whereIn('name', $permissions)
            ->pluck('id')
            ->toArray();

        $user->permissions()->sync($permissionIds);

        return back();
    }
}
