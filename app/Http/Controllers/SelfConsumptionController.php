<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\SelfConsumption;
use App\Http\Requests\SelfConsumptionStoreRequest;
use App\Http\Requests\SelfConsumptionUpdateRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SelfConsumptionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SelfConsumption::class);

        $search = $request->get('search', '');

        // $selfConsumptions = SelfConsumption::search($search)
        //     ->orderBy('date', 'desc')
        //     ->paginate(10)
        //     ->withQueryString();

        if(Auth::user()->hasRole('supervisor|staff|manager')) {
            $selfConsumptions = SelfConsumption::search($search)
                ->where('created_by_id', '=', Auth::user()->id)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } elseif (Auth::user()->hasRole('super-admin')) {
            $selfConsumptions = SelfConsumption::search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view(
            'app.self_consumptions.index',
            compact('selfConsumptions', 'search')
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

        $products = Product::orderBy('name', 'asc')->whereIn('remaining',['1'])->get();

        return view(
            'app.self_consumptions.create',
            compact('stores', 'users', 'users', 'products')
        );
    }

    /**
     * @param \App\Http\Requests\SelfConsumptionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SelfConsumptionStoreRequest $request)
    {
        $this->authorize('create', SelfConsumption::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $selfConsumption = SelfConsumption::create($validated);

        // $selfConsumption->products()->sync($this->mapProducts($validated['products']));

        $products = collect($request->input('products', []))->map(function($product) {
            return ['quantity' => $product];
        });

        $selfConsumption->products()->sync($products);

        return redirect()
            ->route('self-consumptions.edit', $selfConsumption)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SelfConsumption $selfConsumption
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SelfConsumption $selfConsumption)
    {
        $this->authorize('view', $selfConsumption);

        return view('app.self_consumptions.show', compact('selfConsumption'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SelfConsumption $selfConsumption
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SelfConsumption $selfConsumption)
    {
        $this->authorize('update', $selfConsumption);

        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('nickname', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        $selfConsumption->load('products');

        $products = Product::orderBy('name', 'asc')->whereIn('remaining',['1'])->get()
            ->map(function($product) use ($selfConsumption) {
                $product->value = data_get($selfConsumption->products->firstWhere('id', $product->id), 'pivot.quantity') ?? null;
                return $product;
        });

        return view(
            'app.self_consumptions.edit',
            compact('selfConsumption', 'stores', 'users', 'users', 'products')
        );
    }

    /**
     * @param \App\Http\Requests\SelfConsumptionUpdateRequest $request
     * @param \App\Models\SelfConsumption $selfConsumption
     * @return \Illuminate\Http\Response
     */
    public function update(
        SelfConsumptionUpdateRequest $request,
        SelfConsumption $selfConsumption
    ) {
        $this->authorize('update', $selfConsumption);

        $validated = $request->validated();

        // $selfConsumption->products()->sync($this->mapProducts($validated['products']));

        $products = collect($request->input('products', []))->map(function($product) {
            return ['quantity' => $product];
        });

        $selfConsumption->products()->sync($products);

        if (
            auth()
                ->user()
                ->hasRole('super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $selfConsumption->update($validated);

        return redirect()
            ->route('self-consumptions.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SelfConsumption $selfConsumption
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SelfConsumption $selfConsumption)
    {
        $this->authorize('delete', $selfConsumption);

        $selfConsumption->delete();

        return redirect()
            ->route('self-consumptions.index')
            ->withSuccess(__('crud.common.removed'));
    }

    private function mapProducts($products)
    {
        return collect($products)->map(function ($i) {
            return ['quantity' => $i];
        });
    }
}
