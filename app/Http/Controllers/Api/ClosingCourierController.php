<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClosingCourier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ClosingCourierResource;
use App\Http\Resources\ClosingCourierCollection;
use App\Http\Requests\ClosingCourierStoreRequest;
use App\Http\Requests\ClosingCourierUpdateRequest;

class ClosingCourierController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ClosingCourier::class);

        $search = $request->get('search', '');

        $closingCouriers = ClosingCourier::search($search)
            ->latest()
            ->paginate();

        return new ClosingCourierCollection($closingCouriers);
    }

    /**
     * @param \App\Http\Requests\ClosingCourierStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClosingCourierStoreRequest $request)
    {
        $this->authorize('create', ClosingCourier::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $closingCourier = ClosingCourier::create($validated);

        return new ClosingCourierResource($closingCourier);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingCourier $closingCourier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ClosingCourier $closingCourier)
    {
        $this->authorize('view', $closingCourier);

        return new ClosingCourierResource($closingCourier);
    }

    /**
     * @param \App\Http\Requests\ClosingCourierUpdateRequest $request
     * @param \App\Models\ClosingCourier $closingCourier
     * @return \Illuminate\Http\Response
     */
    public function update(
        ClosingCourierUpdateRequest $request,
        ClosingCourier $closingCourier
    ) {
        $this->authorize('update', $closingCourier);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($closingCourier->image) {
                Storage::delete($closingCourier->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $closingCourier->update($validated);

        return new ClosingCourierResource($closingCourier);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ClosingCourier $closingCourier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ClosingCourier $closingCourier)
    {
        $this->authorize('delete', $closingCourier);

        if ($closingCourier->image) {
            Storage::delete($closingCourier->image);
        }

        $closingCourier->delete();

        return response()->noContent();
    }
}
