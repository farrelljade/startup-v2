<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {

        if (array_key_exists('impersonate', $_COOKIE) && !empty($_COOKIE['impersonate'])) {
            $user = User::query()
                ->with('permissions')
                ->find($_COOKIE['impersonate']);
        } else {
            if ($request->user()) {
                $user = User::query()
                    ->with('permissions')
                    ->find($request->user()->id);
            } else {
                $user = [];
            }
        }

        $users = [];
        if ($user && $user->is_admin) {
            $users = User::query()
                ->select(['id', 'name', 'email'])
                ->orderBy('name')
                ->get();
        }

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user,
            ],
            'users' => $users,
        ]);
    }
}
