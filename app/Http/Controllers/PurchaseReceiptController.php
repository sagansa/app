<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use App\Models\PurchaseReceipt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PurchaseReceiptStoreRequest;
use App\Http\Requests\PurchaseReceiptUpdateRequest;

class PurchaseReceiptController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', PurchaseReceipt::class);

        $search = $request->get('search', '');

        $purchaseReceipts = PurchaseReceipt::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.purchase_receipts.index',
            compact('purchaseReceipts', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.purchase_receipts.create');
    }

    /**
     * @param \App\Http\Requests\PurchaseReceiptStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseReceiptStoreRequest $request)
    {
        $this->authorize('create', PurchaseReceipt::class);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileimage = rand() . time() . '.' . $extension;
            $file->move('storage/', $fileimage);
            Image::make('storage/' . $fileimage)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image'] = $fileimage;
        }

        $validated['user_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $purchaseReceipt = PurchaseReceipt::create($validated);

        return redirect()
            ->route('purchase-receipts.show', $purchaseReceipt)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseReceipt $purchaseReceipt
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PurchaseReceipt $purchaseReceipt)
    {
        $this->authorize('view', $purchaseReceipt);

        return view('app.purchase_receipts.show', compact('purchaseReceipt'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseReceipt $purchaseReceipt
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PurchaseReceipt $purchaseReceipt)
    {
        $this->authorize('update', $purchaseReceipt);

        return view('app.purchase_receipts.edit', compact('purchaseReceipt'));
    }

    /**
     * @param \App\Http\Requests\PurchaseReceiptUpdateRequest $request
     * @param \App\Models\PurchaseReceipt $purchaseReceipt
     * @return \Illuminate\Http\Response
     */
    public function update(
        PurchaseReceiptUpdateRequest $request,
        PurchaseReceipt $purchaseReceipt
    ) {
        $this->authorize('update', $purchaseReceipt);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $purchaseReceipt->delete_image();
            $extension = $file->getClientOriginalExtension();
            $file_image = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_image);
            Image::make('storage/' . $file_image)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image'] = $file_image;
        }

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $purchaseReceipt->update($validated);

        return redirect()
            ->route('purchase-receipts.show', $purchaseReceipt)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseReceipt $purchaseReceipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PurchaseReceipt $purchaseReceipt)
    {
        $this->authorize('delete', $purchaseReceipt);

        if ($purchaseReceipt->image) {
            Storage::delete($purchaseReceipt->image);
        }

        $purchaseReceipt->delete();

        return redirect()
            ->route('purchase-receipts.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
