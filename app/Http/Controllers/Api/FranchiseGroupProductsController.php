<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\FranchiseGroup;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class FranchiseGroupProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FranchiseGroup $franchiseGroup
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, FranchiseGroup $franchiseGroup)
    {
        $this->authorize('view', $franchiseGroup);

        $search = $request->get('search', '');

        $products = $franchiseGroup
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FranchiseGroup $franchiseGroup
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FranchiseGroup $franchiseGroup)
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
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'online_category_id' => ['required', 'exists:online_categories,id'],
            'product_group_id' => ['required', 'exists:product_groups,id'],
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

        $product = $franchiseGroup->products()->create($validated);

        return new ProductResource($product);
    }
}
