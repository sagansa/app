<?php

namespace App\Http\Controllers\Api;

use App\Models\Refund;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RefundResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\RefundCollection;
use App\Http\Requests\RefundStoreRequest;
use App\Http\Requests\RefundUpdateRequest;

class RefundController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Refund::class);

        $search = $request->get('search', '');

        $refunds = Refund::search($search)
            ->latest()
            ->paginate();

        return new RefundCollection($refunds);
    }

    /**
     * @param \App\Http\Requests\RefundStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RefundStoreRequest $request)
    {
        $this->authorize('create', Refund::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $refund = Refund::create($validated);

        return new RefundResource($refund);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Refund $refund
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Refund $refund)
    {
        $this->authorize('view', $refund);

        return new RefundResource($refund);
    }

    /**
     * @param \App\Http\Requests\RefundUpdateRequest $request
     * @param \App\Models\Refund $refund
     * @return \Illuminate\Http\Response
     */
    public function update(RefundUpdateRequest $request, Refund $refund)
    {
        $this->authorize('update', $refund);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($refund->image) {
                Storage::delete($refund->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $refund->update($validated);

        return new RefundResource($refund);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Refund $refund
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Refund $refund)
    {
        $this->authorize('delete', $refund);

        if ($refund->image) {
            Storage::delete($refund->image);
        }

        $refund->delete();

        return response()->noContent();
    }
}
