<?php

namespace App\Http\Controllers\Api;

use App\Models\UtilityBill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\UtilityBillResource;
use App\Http\Resources\UtilityBillCollection;
use App\Http\Requests\UtilityBillStoreRequest;
use App\Http\Requests\UtilityBillUpdateRequest;

class UtilityBillController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', UtilityBill::class);

        $search = $request->get('search', '');

        $utilityBills = UtilityBill::search($search)
            ->latest()
            ->paginate();

        return new UtilityBillCollection($utilityBills);
    }

    /**
     * @param \App\Http\Requests\UtilityBillStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UtilityBillStoreRequest $request)
    {
        $this->authorize('create', UtilityBill::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $utilityBill = UtilityBill::create($validated);

        return new UtilityBillResource($utilityBill);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UtilityBill $utilityBill
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, UtilityBill $utilityBill)
    {
        $this->authorize('view', $utilityBill);

        return new UtilityBillResource($utilityBill);
    }

    /**
     * @param \App\Http\Requests\UtilityBillUpdateRequest $request
     * @param \App\Models\UtilityBill $utilityBill
     * @return \Illuminate\Http\Response
     */
    public function update(
        UtilityBillUpdateRequest $request,
        UtilityBill $utilityBill
    ) {
        $this->authorize('update', $utilityBill);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($utilityBill->image) {
                Storage::delete($utilityBill->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $utilityBill->update($validated);

        return new UtilityBillResource($utilityBill);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UtilityBill $utilityBill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, UtilityBill $utilityBill)
    {
        $this->authorize('delete', $utilityBill);

        if ($utilityBill->image) {
            Storage::delete($utilityBill->image);
        }

        $utilityBill->delete();

        return response()->noContent();
    }
}
