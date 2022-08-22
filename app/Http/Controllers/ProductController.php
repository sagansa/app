<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Unit;
use App\Models\Product;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Models\ProductGroup;
use App\Models\MaterialGroup;
use App\Models\FranchiseGroup;
use App\Models\OnlineCategory;
use App\Models\RestaurantCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Product::class);

        $search = $request->get('search', '');

        $products = Product::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.products.index', compact('products', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $units = Unit::orderBy('unit', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('unit', 'id');
        $materialGroups = MaterialGroup::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $franchiseGroups = FranchiseGroup::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $paymentTypes = PaymentType::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $onlineCategories = OnlineCategory::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $productGroups = ProductGroup::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $restaurantCategories = RestaurantCategory::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.products.create',
            compact(
                'units',
                'materialGroups',
                'franchiseGroups',
                'paymentTypes',
                'onlineCategories',
                'productGroups',
                'restaurantCategories'
            )
        );
    }

    /**
     * @param \App\Http\Requests\ProductStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $this->authorize('create', Product::class);

        $validated = $request->validated();

        if ($request->hasFile('barcode')) {
            $file = $request->file('barcode');
            $extension = $file->getClientOriginalExtension();
            $filebarcode = rand() . time() . '.' . $extension;
            $file->move('storage/', $filebarcode);
            Image::make('storage/' . $filebarcode)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['barcode'] = $filebarcode;
        }

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

        $product = Product::create($validated);

        return redirect()
            ->route('products.edit', $product)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        $this->authorize('view', $product);

        return view('app.products.show', compact('product'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $units = Unit::orderBy('unit', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('unit', 'id');
        $materialGroups = MaterialGroup::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $franchiseGroups = FranchiseGroup::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $paymentTypes = PaymentType::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $onlineCategories = OnlineCategory::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $productGroups = ProductGroup::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $restaurantCategories = RestaurantCategory::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.products.edit',
            compact(
                'product',
                'units',
                'materialGroups',
                'franchiseGroups',
                'paymentTypes',
                'onlineCategories',
                'productGroups',
                'restaurantCategories'
            )
        );
    }

    /**
     * @param \App\Http\Requests\ProductUpdateRequest $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validated();
        if ($request->hasFile('barcode')) {
            $file = $request->file('barcode');
            $product->delete_barcode();
            $extension = $file->getClientOriginalExtension();
            $file_barcode = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_barcode);
            Image::make('storage/' . $file_barcode)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['barcode'] = $file_barcode;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $product->delete_image();
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

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        $this->authorize('delete', $product);

        if ($product->barcode) {
            Storage::delete($product->barcode);
        }

        if ($product->image) {
            Storage::delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
