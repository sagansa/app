<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class ProductGroupProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductGroup $productGroup
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ProductGroup $productGroup)
    {
        $this->authorize('view', $productGroup);

        $search = $request->get('search', '');

        $products = $productGroup
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductGroup $productGroup
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProductGroup $productGroup)
    {
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'barcode' => ['image', 'max:1024', 'nullable'],
            'image' => ['nullable', 'image', 'max:1024'],
            'name' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:50', 'string'],
            'sku' => ['nullable', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'unit_id' => ['required', 'exists:units,id'],
            'material_group_id' => ['required', 'exists:material_groups,id'],
            'franchise_group_id' => ['required', 'exists:franchise_groups,id'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'online_category_id' => ['required', 'exists:online_categories,id'],
            'restaurant_category_id' => [
                'required',
                'exists:restaurant_categories,id',
            ],
            'request' => ['required', 'max:255'],
            'remaining' => ['required', 'max:255'],
        ]);

        if ($request->hasFile('barcode')) {
            $validated['barcode'] = $request->file('barcode')->store('public');
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $product = $productGroup->products()->create($validated);

        return new ProductResource($product);
    }
}
