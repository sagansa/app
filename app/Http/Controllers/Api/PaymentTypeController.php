<?php

namespace App\Http\Controllers\Api;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentTypeResource;
use App\Http\Resources\PaymentTypeCollection;
use App\Http\Requests\PaymentTypeStoreRequest;
use App\Http\Requests\PaymentTypeUpdateRequest;

class PaymentTypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', PaymentType::class);

        $search = $request->get('search', '');

        $paymentTypes = PaymentType::search($search)
            ->latest()
            ->paginate();

        return new PaymentTypeCollection($paymentTypes);
    }

    /**
     * @param \App\Http\Requests\PaymentTypeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentTypeStoreRequest $request)
    {
        $this->authorize('create', PaymentType::class);

        $validated = $request->validated();

        $paymentType = PaymentType::create($validated);

        return new PaymentTypeResource($paymentType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentType $paymentType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PaymentType $paymentType)
    {
        $this->authorize('view', $paymentType);

        return new PaymentTypeResource($paymentType);
    }

    /**
     * @param \App\Http\Requests\PaymentTypeUpdateRequest $request
     * @param \App\Models\PaymentType $paymentType
     * @return \Illuminate\Http\Response
     */
    public function update(
        PaymentTypeUpdateRequest $request,
        PaymentType $paymentType
    ) {
        $this->authorize('update', $paymentType);

        $validated = $request->validated();

        $paymentType->update($validated);

        return new PaymentTypeResource($paymentType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentType $paymentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PaymentType $paymentType)
    {
        $this->authorize('delete', $paymentType);

        $paymentType->delete();

        return response()->noContent();
    }
}
