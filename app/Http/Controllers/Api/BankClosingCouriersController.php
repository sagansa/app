<?php

namespace App\Http\Controllers\Api;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClosingCourierResource;
use App\Http\Resources\ClosingCourierCollection;

class BankClosingCouriersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Bank $bank)
    {
        $this->authorize('view', $bank);

        $search = $request->get('search', '');

        $closingCouriers = $bank
            ->closingCouriers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ClosingCourierCollection($closingCouriers);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Bank $bank)
    {
        $this->authorize('create', ClosingCourier::class);

        $validated = $request->validate([
            'image' => ['nullable', 'image'],
            'total_cash_to_transfer' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', 'in:1,2,3,4'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $closingCourier = $bank->closingCouriers()->create($validated);

        return new ClosingCourierResource($closingCourier);
    }
}
