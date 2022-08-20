<?php

namespace App\Http\Controllers;

use Image;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductGroupStoreRequest;
use App\Http\Requests\ProductGroupUpdateRequest;

class ProductGroupController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ProductGroup::class);

        $search = $request->get('search', '');

        $productGroups = ProductGroup::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.product_groups.index',
            compact('productGroups', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.product_groups.create');
    }

    /**
     * @param \App\Http\Requests\ProductGroupStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductGroupStoreRequest $request)
    {
        $this->authorize('create', ProductGroup::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $productGroup = ProductGroup::create($validated);

        return redirect()
            ->route('product-groups.edit', $productGroup)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductGroup $productGroup
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ProductGroup $productGroup)
    {
        $this->authorize('view', $productGroup);

        return view('app.product_groups.show', compact('productGroup'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductGroup $productGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ProductGroup $productGroup)
    {
        $this->authorize('update', $productGroup);

        return view('app.product_groups.edit', compact('productGroup'));
    }

    /**
     * @param \App\Http\Requests\ProductGroupUpdateRequest $request
     * @param \App\Models\ProductGroup $productGroup
     * @return \Illuminate\Http\Response
     */
    public function update(
        ProductGroupUpdateRequest $request,
        ProductGroup $productGroup
    ) {
        $this->authorize('update', $productGroup);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $productGroup->update($validated);

        return redirect()
            ->route('product-groups.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductGroup $productGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ProductGroup $productGroup)
    {
        $this->authorize('delete', $productGroup);

        $productGroup->delete();

        return redirect()
            ->route('product-groups.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
