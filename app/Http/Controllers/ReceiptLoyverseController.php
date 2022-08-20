<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use App\Models\ReceiptLoyverse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReceiptLoyverseStoreRequest;
use App\Http\Requests\ReceiptLoyverseUpdateRequest;

class ReceiptLoyverseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ReceiptLoyverse::class);

        $search = $request->get('search', '');

        $receiptLoyverses = ReceiptLoyverse::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.receipt_loyverses.index',
            compact('receiptLoyverses', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.receipt_loyverses.create');
    }

    /**
     * @param \App\Http\Requests\ReceiptLoyverseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReceiptLoyverseStoreRequest $request)
    {
        $this->authorize('create', ReceiptLoyverse::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $receiptLoyverse = ReceiptLoyverse::create($validated);

        return redirect()
            ->route('receipt-loyverses.edit', $receiptLoyverse)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ReceiptLoyverse $receiptLoyverse
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ReceiptLoyverse $receiptLoyverse)
    {
        $this->authorize('view', $receiptLoyverse);

        return view('app.receipt_loyverses.show', compact('receiptLoyverse'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ReceiptLoyverse $receiptLoyverse
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ReceiptLoyverse $receiptLoyverse)
    {
        $this->authorize('update', $receiptLoyverse);

        return view('app.receipt_loyverses.edit', compact('receiptLoyverse'));
    }

    /**
     * @param \App\Http\Requests\ReceiptLoyverseUpdateRequest $request
     * @param \App\Models\ReceiptLoyverse $receiptLoyverse
     * @return \Illuminate\Http\Response
     */
    public function update(
        ReceiptLoyverseUpdateRequest $request,
        ReceiptLoyverse $receiptLoyverse
    ) {
        $this->authorize('update', $receiptLoyverse);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $receiptLoyverse->update($validated);

        return redirect()
            ->route('receipt-loyverses.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ReceiptLoyverse $receiptLoyverse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ReceiptLoyverse $receiptLoyverse)
    {
        $this->authorize('delete', $receiptLoyverse);

        $receiptLoyverse->delete();

        return redirect()
            ->route('receipt-loyverses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
