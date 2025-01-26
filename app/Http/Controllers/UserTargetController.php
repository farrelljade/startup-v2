<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserTargetStoreRequest;
use App\Http\Requests\UserTargetUpdateRequest;
use App\Models\Order;
use App\Models\Target;
use App\Models\User;
use App\Models\UserTarget;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserTargetController extends Controller
{
    public function index()
    {
        $data = [];

        $data['users'] = User::query()
            ->with(['targets' => function($query) {
                $query->with('target');
            }])
            ->get();

        return Inertia::render('Admin/UserTargets', $data);
    }

    public function store(UserTargetStoreRequest $request): JsonResponse
    {
        DB::transaction(function () use ($request) {
            foreach ($request->validated()['targets'] as $target) {
                $targetId = Target::where('type', $target['type'])->value('id');

                UserTarget::create([
                    'user_id' => $target['user_id'],
                    'target_id' => $targetId,
                    'target_value' => $target['value'],
                    'current_value' => 0,
                    'start_date' => $target['start_date'],
                    'end_date' => $target['end_date']
                ]);
            }
        });

        return response()->json(['message' => 'Targets updated!']);
    }

    public function update(UserTargetUpdateRequest $request, string $userTargetId): JsonResponse
    {
        $validated = $request->validated();

        $userTarget = UserTarget::findOrFail($userTargetId);

        if ($userTarget->target->type === 'profit') {
            $currentProfit = Order::query()
                ->whereHas('customer', function($query) use ($userTarget) {
                    $query->where('user_id', $userTarget->user_id);
                })
                ->whereMonth('created_at', now()->month)
                ->sum('total_profit');

            $userTarget->current_value = $currentProfit;
        }

        $userTarget->target_value = $validated['target_value'];
        $userTarget->achieved = $userTarget->current_value >= $validated['target_value'];
        $userTarget->save();

        return response()->json(['message' => 'Target updated!']);
    }
}
