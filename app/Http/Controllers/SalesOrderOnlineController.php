<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Store;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\DeliveryService;
use App\Models\SalesOrderOnline;
use App\Models\OnlineShopProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SalesOrderOnlineStoreRequest;
use App\Http\Requests\SalesOrderOnlineUpdateRequest;

class SalesOrderOnlineController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SalesOrderOnline::class);

        $search = $request->get('search', '');

        $salesOrderOnlines = SalesOrderOnline::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.sales_order_onlines.index',
            compact('salesOrderOnlines', 'search')
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
        $onlineShopProviders = OnlineShopProvider::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $deliveryServices = DeliveryService::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $customers = Customer::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.sales_order_onlines.create',
            compact(
                'stores',
                'onlineShopProviders',
                'deliveryServices',
                'customers',
                'users',
                'users'
            )
        );
    }

    /**
     * @param \App\Http\Requests\SalesOrderOnlineStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesOrderOnlineStoreRequest $request)
    {
        $this->authorize('create', SalesOrderOnline::class);

        $validated = $request->validated();

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('image_sent')) {
            $validated['image_sent'] = $request
                ->file('image_sent')
                ->store('public');
        }

        // if ($request->hasFile('image')) {
        //     $file = $request->file('image');
        //     $extension = $file->getClientOriginalExtension();
        //     $fileimage = rand() . time() . '.' . $extension;
        //     $file->move('storage/', $fileimage);
        //     Image::make('storage/' . $fileimage)
        //         ->resize(800, 800, function ($constraint) {
        //             $constraint->aspectRatio();
        //             $constraint->upsize();
        //         })
        //         ->save();

        //     $validated['image'] = $fileimage;
        // }

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $salesOrderOnline = SalesOrderOnline::create($validated);

        return redirect()
            ->route('sales-order-onlines.edit', $salesOrderOnline)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SalesOrderOnline $salesOrderOnline
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SalesOrderOnline $salesOrderOnline)
    {
        $this->authorize('view', $salesOrderOnline);

        return view(
            'app.sales_order_onlines.show',
            compact('salesOrderOnline')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SalesOrderOnline $salesOrderOnline
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SalesOrderOnline $salesOrderOnline)
    {
        $this->authorize('update', $salesOrderOnline);

        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('nickname', 'id');
        $onlineShopProviders = OnlineShopProvider::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $deliveryServices = DeliveryService::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $customers = Customer::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.sales_order_onlines.edit',
            compact(
                'salesOrderOnline',
                'stores',
                'onlineShopProviders',
                'deliveryServices',
                'customers',
                'users',
                'users'
            )
        );
    }

    /**
     * @param \App\Http\Requests\SalesOrderOnlineUpdateRequest $request
     * @param \App\Models\SalesOrderOnline $salesOrderOnline
     * @return \Illuminate\Http\Response
     */
    public function update(
        SalesOrderOnlineUpdateRequest $request,
        SalesOrderOnline $salesOrderOnline
    ) {
        $this->authorize('update', $salesOrderOnline);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($salesOrderOnline->image) {
                Storage::delete($salesOrderOnline->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('image_sent')) {
            if ($salesOrderOnline->image_sent) {
                Storage::delete($salesOrderOnline->image_sent);
            }

            $validated['image_sent'] = $request
                ->file('image_sent')
                ->store('public');
        }

        // $validated = $request->validated();
        // if ($request->hasFile('image')) {
        //     $file = $request->file('image');
        //     $salesOrderOnline->delete_image();
        //     $extension = $file->getClientOriginalExtension();
        //     $file_image = rand() . time() . '.' . $extension;
        //     $file->move('storage/', $file_image);
        //     Image::make('storage/' . $file_image)
        //         ->resize(400, 400, function ($constraint) {
        //             $constraint->aspectRatio();
        //             $constraint->upsize();
        //         })
        //         ->save();

        //     $validated['image'] = $file_image;
        // }

        if (
            auth()
                ->user()
                ->hasRole('storage-staff')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $salesOrderOnline->update($validated);

        return redirect()
            ->route('sales-order-onlines.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SalesOrderOnline $salesOrderOnline
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        SalesOrderOnline $salesOrderOnline
    ) {
        $this->authorize('delete', $salesOrderOnline);

        if ($salesOrderOnline->image) {
            Storage::delete($salesOrderOnline->image);
        }

        $salesOrderOnline->delete();

        return redirect()
            ->route('sales-order-onlines.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
