<?php

namespace App\Http\Controllers;

use Image;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.payment_types.index',
            compact('paymentTypes', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.payment_types.create');
    }

    /**
     * @param \App\Http\Requests\PaymentTypeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentTypeStoreRequest $request)
    {
        $this->authorize('create', PaymentType::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $paymentType = PaymentType::create($validated);

        return redirect()
            ->route('payment-types.edit', $paymentType)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentType $paymentType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PaymentType $paymentType)
    {
        $this->authorize('view', $paymentType);

        return view('app.payment_types.show', compact('paymentType'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentType $paymentType
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PaymentType $paymentType)
    {
        $this->authorize('update', $paymentType);

        return view('app.payment_types.edit', compact('paymentType'));
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

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $paymentType->update($validated);

        return redirect()
            ->route('payment-types.index')
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('payment-types.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
