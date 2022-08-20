<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Store;
use App\Models\Product;
use App\Models\RequestStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RequestStockStoreRequest;
use App\Http\Requests\RequestStockUpdateRequest;

class RequestStockController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', RequestStock::class);

        $search = $request->get('search', '');

        $requestStocks = RequestStock::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.request_stocks.index',
            compact('requestStocks', 'search')
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

        $products = Product::orderBy('name', 'asc')->whereIn('request', ['1'])->get();

        return view('app.request_stocks.create', compact('stores', 'products'));
    }

    /**
     * @param \App\Http\Requests\RequestStockStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestStockStoreRequest $request)
    {
        $this->authorize('create', RequestStock::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $requestStock = RequestStock::create($validated);

        $requestStock->products()->attach($request->products);

        return redirect()
            ->route('request-stocks.edit', $requestStock)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RequestStock $requestStock
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, RequestStock $requestStock)
    {
        $this->authorize('view', $requestStock);

        return view('app.request_stocks.show', compact('requestStock'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RequestStock $requestStock
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, RequestStock $requestStock)
    {
        $this->authorize('update', $requestStock);

        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('nickname', 'id');

        $products = Product::orderBy('name', 'asc')->whereIn('request', ['1'])->get();

        return view(
            'app.request_stocks.edit',
            compact('requestStock', 'stores', 'products')
        );
    }

    /**
     * @param \App\Http\Requests\RequestStockUpdateRequest $request
     * @param \App\Models\RequestStock $requestStock
     * @return \Illuminate\Http\Response
     */
    public function update(
        RequestStockUpdateRequest $request,
        RequestStock $requestStock
    ) {
        $this->authorize('update', $requestStock);

        $validated = $request->validated();
        $requestStock->products()->sync($request->products);

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $requestStock->update($validated);

        return redirect()
            ->route('request-stocks.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RequestStock $requestStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RequestStock $requestStock)
    {
        $this->authorize('delete', $requestStock);

        $requestStock->delete();

        return redirect()
            ->route('request-stocks.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
