<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CleanAndNeatResource;
use App\Http\Resources\CleanAndNeatCollection;

class UserCleanAndNeatsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $cleanAndNeats = $user
            ->cleanAndNeatsApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new CleanAndNeatCollection($cleanAndNeats);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', CleanAndNeat::class);

        $validated = $request->validate([
            'left_hand' => ['image', 'nullable'],
            'right_hand' => ['image', 'nullable'],
            'status' => ['max:1', 'nullable'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('left_hand')) {
            $validated['left_hand'] = $request
                ->file('left_hand')
                ->store('public');
        }

        if ($request->hasFile('right_hand')) {
            $validated['right_hand'] = $request
                ->file('right_hand')
                ->store('public');
        }

        $cleanAndNeat = $user->cleanAndNeatsApproved()->create($validated);

        return new CleanAndNeatResource($cleanAndNeat);
    }
}
