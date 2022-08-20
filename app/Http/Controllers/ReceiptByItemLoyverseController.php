<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ReceiptByItemLoyverse;
use App\Http\Requests\ReceiptByItemLoyverseStoreRequest;
use App\Http\Requests\ReceiptByItemLoyverseUpdateRequest;

class ReceiptByItemLoyverseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ReceiptByItemLoyverse::class);

        $search = $request->get('search', '');

        $receiptByItemLoyverses = ReceiptByItemLoyverse::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.receipt_by_item_loyverses.index',
            compact('receiptByItemLoyverses', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.receipt_by_item_loyverses.create');
    }

    /**
     * @param \App\Http\Requests\ReceiptByItemLoyverseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReceiptByItemLoyverseStoreRequest $request)
    {
        $this->authorize('create', ReceiptByItemLoyverse::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $receiptByItemLoyverse = ReceiptByItemLoyverse::create($validated);

        return redirect()
            ->route('receipt-by-item-loyverses.edit', $receiptByItemLoyverse)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ReceiptByItemLoyverse $receiptByItemLoyverse
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        ReceiptByItemLoyverse $receiptByItemLoyverse
    ) {
        $this->authorize('view', $receiptByItemLoyverse);

        return view(
            'app.receipt_by_item_loyverses.show',
            compact('receiptByItemLoyverse')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ReceiptByItemLoyverse $receiptByItemLoyverse
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        ReceiptByItemLoyverse $receiptByItemLoyverse
    ) {
        $this->authorize('update', $receiptByItemLoyverse);

        return view(
            'app.receipt_by_item_loyverses.edit',
            compact('receiptByItemLoyverse')
        );
    }

    /**
     * @param \App\Http\Requests\ReceiptByItemLoyverseUpdateRequest $request
     * @param \App\Models\ReceiptByItemLoyverse $receiptByItemLoyverse
     * @return \Illuminate\Http\Response
     */
    public function update(
        ReceiptByItemLoyverseUpdateRequest $request,
        ReceiptByItemLoyverse $receiptByItemLoyverse
    ) {
        $this->authorize('update', $receiptByItemLoyverse);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $receiptByItemLoyverse->update($validated);

        return redirect()
            ->route('receipt-by-item-loyverses.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ReceiptByItemLoyverse $receiptByItemLoyverse
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        ReceiptByItemLoyverse $receiptByItemLoyverse
    ) {
        $this->authorize('delete', $receiptByItemLoyverse);

        $receiptByItemLoyverse->delete();

        return redirect()
            ->route('receipt-by-item-loyverses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
