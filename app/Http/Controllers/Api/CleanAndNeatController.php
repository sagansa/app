<?php

namespace App\Http\Controllers\Api;

use App\Models\CleanAndNeat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CleanAndNeatResource;
use App\Http\Resources\CleanAndNeatCollection;
use App\Http\Requests\CleanAndNeatStoreRequest;
use App\Http\Requests\CleanAndNeatUpdateRequest;

class CleanAndNeatController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', CleanAndNeat::class);

        $search = $request->get('search', '');

        $cleanAndNeats = CleanAndNeat::search($search)
            ->latest()
            ->paginate();

        return new CleanAndNeatCollection($cleanAndNeats);
    }

    /**
     * @param \App\Http\Requests\CleanAndNeatStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CleanAndNeatStoreRequest $request)
    {
        $this->authorize('create', CleanAndNeat::class);

        $validated = $request->validated();
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

        $cleanAndNeat = CleanAndNeat::create($validated);

        return new CleanAndNeatResource($cleanAndNeat);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CleanAndNeat $cleanAndNeat
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, CleanAndNeat $cleanAndNeat)
    {
        $this->authorize('view', $cleanAndNeat);

        return new CleanAndNeatResource($cleanAndNeat);
    }

    /**
     * @param \App\Http\Requests\CleanAndNeatUpdateRequest $request
     * @param \App\Models\CleanAndNeat $cleanAndNeat
     * @return \Illuminate\Http\Response
     */
    public function update(
        CleanAndNeatUpdateRequest $request,
        CleanAndNeat $cleanAndNeat
    ) {
        $this->authorize('update', $cleanAndNeat);

        $validated = $request->validated();

        if ($request->hasFile('left_hand')) {
            if ($cleanAndNeat->left_hand) {
                Storage::delete($cleanAndNeat->left_hand);
            }

            $validated['left_hand'] = $request
                ->file('left_hand')
                ->store('public');
        }

        if ($request->hasFile('right_hand')) {
            if ($cleanAndNeat->right_hand) {
                Storage::delete($cleanAndNeat->right_hand);
            }

            $validated['right_hand'] = $request
                ->file('right_hand')
                ->store('public');
        }

        $cleanAndNeat->update($validated);

        return new CleanAndNeatResource($cleanAndNeat);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CleanAndNeat $cleanAndNeat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CleanAndNeat $cleanAndNeat)
    {
        $this->authorize('delete', $cleanAndNeat);

        if ($cleanAndNeat->left_hand) {
            Storage::delete($cleanAndNeat->left_hand);
        }

        if ($cleanAndNeat->right_hand) {
            Storage::delete($cleanAndNeat->right_hand);
        }

        $cleanAndNeat->delete();

        return response()->noContent();
    }
}
