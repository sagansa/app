<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\TransferDailySalary;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\TransferDailySalaryResource;
use App\Http\Resources\TransferDailySalaryCollection;
use App\Http\Requests\TransferDailySalaryStoreRequest;
use App\Http\Requests\TransferDailySalaryUpdateRequest;

class TransferDailySalaryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', TransferDailySalary::class);

        $search = $request->get('search', '');

        $transferDailySalaries = TransferDailySalary::search($search)
            ->latest()
            ->paginate();

        return new TransferDailySalaryCollection($transferDailySalaries);
    }

    /**
     * @param \App\Http\Requests\TransferDailySalaryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransferDailySalaryStoreRequest $request)
    {
        $this->authorize('create', TransferDailySalary::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $transferDailySalary = TransferDailySalary::create($validated);

        return new TransferDailySalaryResource($transferDailySalary);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferDailySalary $transferDailySalary
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        TransferDailySalary $transferDailySalary
    ) {
        $this->authorize('view', $transferDailySalary);

        return new TransferDailySalaryResource($transferDailySalary);
    }

    /**
     * @param \App\Http\Requests\TransferDailySalaryUpdateRequest $request
     * @param \App\Models\TransferDailySalary $transferDailySalary
     * @return \Illuminate\Http\Response
     */
    public function update(
        TransferDailySalaryUpdateRequest $request,
        TransferDailySalary $transferDailySalary
    ) {
        $this->authorize('update', $transferDailySalary);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($transferDailySalary->image) {
                Storage::delete($transferDailySalary->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $transferDailySalary->update($validated);

        return new TransferDailySalaryResource($transferDailySalary);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferDailySalary $transferDailySalary
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        TransferDailySalary $transferDailySalary
    ) {
        $this->authorize('delete', $transferDailySalary);

        if ($transferDailySalary->image) {
            Storage::delete($transferDailySalary->image);
        }

        $transferDailySalary->delete();

        return response()->noContent();
    }
}
