<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PurchaseOrderStoreRequest;
use App\Http\Requests\PurchaseOrderUpdateRequest;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', PurchaseOrder::class);

        $search = $request->get('search', '');

        // $purchaseOrders = PurchaseOrder::search($search)
        //     ->latest()
        //     ->paginate(10)
        //     ->withQueryString();

        if(Auth::user()->hasRole('supervisor')) {
            $purchaseOrders = PurchaseOrder::search($search)
                ->where('approved_by_id', '=', Auth::user()->id)
                ->orWhere('approved_by_id', '=', NULL)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } elseif (Auth::user()->hasRole('super-admin|manager')) {
            $purchaseOrders = PurchaseOrder::search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } else if (Auth::user()->hasRole('staff')) {
            $purchaseOrders = PurchaseOrder::search($search)
                ->where('created_by_id', '=', Auth::user()->id)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view(
            'app.purchase_orders.index',
            compact('purchaseOrders', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('nickname', 'id');
        $suppliers = Supplier::orderBy('name', 'asc')
            // ->whereNotIn('status', ['1,3'])
            ->get()
            ->pluck('name', 'id');
        $paymentTypes = PaymentType::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.purchase_orders.create',
            compact('stores', 'suppliers', 'paymentTypes', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\PurchaseOrderStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseOrderStoreRequest $request)
    {
        $this->authorize('create', PurchaseOrder::class);

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

        $validated['created_by_id'] = auth()->user()->id;
        $validated['payment_status'] = '1';
        $validated['discounts'] = '0';
        $validated['taxes'] = '0';

        // dd($validated);

        $purchaseOrder = PurchaseOrder::create($validated);

        return redirect()
            ->route('purchase-orders.show', $purchaseOrder)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PurchaseOrder $purchaseOrder)
    {
        $this->authorize('view', $purchaseOrder);

        return view('app.purchase_orders.show', compact('purchaseOrder'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PurchaseOrder $purchaseOrder)
    {
        $this->authorize('update', $purchaseOrder);

        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('nickname', 'id');
        $suppliers = Supplier::orderBy('name', 'asc')
            // ->whereNotIn('status', ['1,3'])
            ->pluck('name', 'id');
        $paymentTypes = PaymentType::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.purchase_orders.edit',
            compact(
                'purchaseOrder',
                'stores',
                'suppliers',
                'paymentTypes',
                'users',
                'users'
            )
        );
    }

    /**
     * @param \App\Http\Requests\PurchaseOrderUpdateRequest $request
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(
        PurchaseOrderUpdateRequest $request,
        PurchaseOrder $purchaseOrder
    ) {
        $this->authorize('update', $purchaseOrder);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $purchaseOrder->delete_image();
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
                ->hasRole('manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $purchaseOrder->update($validated);

        return redirect()
            ->route('purchase-orders.show', $purchaseOrder)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PurchaseOrder $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PurchaseOrder $purchaseOrder)
    {
        $this->authorize('delete', $purchaseOrder);

        if ($purchaseOrder->image) {
            Storage::delete($purchaseOrder->image);
        }

        $purchaseOrder->delete();

        return redirect()
            ->route('purchase-orders.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
