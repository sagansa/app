<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RemainingStock;
use App\Http\Requests\RemainingStockStoreRequest;
use App\Http\Requests\RemainingStockUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Rules\Role;

class RemainingStockController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', RemainingStock::class);

        $search = $request->get('search', '');

        // $remainingStocks = RemainingStock::search($search)
        //     ->latest()
        //     ->paginate(10)
        //     ->withQueryString();

        if(Auth::user()->hasRole('supervisor')) {
            $remainingStocks = RemainingStock::search($search)
                ->where('approved_by_id', '=', Auth::user()->id)
                ->orWhere('approved_by_id', '=', NULL)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } elseif (Auth::user()->hasRole('super-admin|manager')) {
            $remainingStocks = RemainingStock::search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } else if (Auth::user()->hasRole('staff')) {
            $remainingStocks = RemainingStock::search($search)
                ->where('created_by_id', '=', Auth::user()->id)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view(
            'app.remaining_stocks.index',
            compact('remainingStocks', 'search')
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
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $products = Product::orderBy('name', 'asc')
            ->whereIn('remaining',['1'])
            ->get();
            // ->pluck('product_name', 'id');

        return view(
            'app.remaining_stocks.create',
            compact('stores', 'users', 'users', 'products')
        );
    }

    /**
     * @param \App\Http\Requests\RemainingStockStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RemainingStockStoreRequest $request)
    {
        $this->authorize('create', RemainingStock::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $remainingStock = RemainingStock::create($validated);
        
        // if(auth()->user()->hasRole('manager|staff|super-admin')) {
        $remainingStock->products()->sync($this->mapProducts($validated['products']));
        // }

        return redirect()
            ->route('remaining-stocks.edit', $remainingStock)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RemainingStock $remainingStock
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, RemainingStock $remainingStock)
    {
        $this->authorize('view', $remainingStock);

        return view('app.remaining_stocks.show', compact('remainingStock'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RemainingStock $remainingStock
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, RemainingStock $remainingStock)
    {
        $this->authorize('update', $remainingStock);

        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('nickname', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        $remainingStock->load('products');

        $products = Product::orderBy('name', 'asc')->whereIn('remaining',['1'])->get()
            ->map(function($product) use ($remainingStock) {
                $product->value = data_get($remainingStock->products->firstWhere('id', $product->id), 'pivot.quantity') ?? null;
                return $product;
        });

        return view(
            'app.remaining_stocks.edit',
            compact('remainingStock', 'stores', 'users', 'users', 'products')
        );
    }

    /**
     * @param \App\Http\Requests\RemainingStockUpdateRequest $request
     * @param \App\Models\RemainingStock $remainingStock
     * @return \Illuminate\Http\Response
     */
    public function update(
        RemainingStockUpdateRequest $request,
        RemainingStock $remainingStock
    ) {
        $this->authorize('update', $remainingStock);

        $validated = $request->validated();

        $remainingStock->products()->sync($this->mapProducts($validated['products']));

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $remainingStock->update($validated);

        return redirect()
            ->route('remaining-stocks.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RemainingStock $remainingStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RemainingStock $remainingStock)
    {
        $this->authorize('delete', $remainingStock);

        $remainingStock->delete();

        return redirect()
            ->route('remaining-stocks.index')
            ->withSuccess(__('crud.common.removed'));
    }

    private function mapProducts($products) 
    {
        return collect($products)->map(function ($i) {
            return ['quantity' => $i];
        });
    }
}
