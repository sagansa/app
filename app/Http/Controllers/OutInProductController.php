<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\StockCard;
use App\Models\OutInProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\OutInProductStoreRequest;
use App\Http\Requests\OutInProductUpdateRequest;
use Carbon\Carbon;

class OutInProductController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', OutInProduct::class);

        $search = $request->get('search', '');

        // $outInProducts = OutInProduct::search($search)
        //     ->latest()
        //     ->paginate(10)
        //     ->withQueryString();
        
        if (Auth::user()->hasRole('super-admin|manager')) {
            $outInProducts = OutInProduct::search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } else if (Auth::user()->hasRole('storage-staff')) {
            $outInProducts = OutInProduct::search($search)
                ->where('created_by_id', '=', Auth::user()->id)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view(
            'app.out_in_products.index',
            compact('outInProducts', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stockCards = StockCard::orderBy('date', 'asc')
            ->where('date', '>', Carbon::now()->subDays(2)->toDateString())
            ->get()
            ->pluck('stock_card_name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.out_in_products.create',
            compact('stockCards', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\OutInProductStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OutInProductStoreRequest $request)
    {
        $this->authorize('create', OutInProduct::class);

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

        $outInProduct = OutInProduct::create($validated);

        return redirect()
            ->route('out-in-products.edit', $outInProduct)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OutInProduct $outInProduct
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, OutInProduct $outInProduct)
    {
        $this->authorize('view', $outInProduct);

        return view('app.out_in_products.show', compact('outInProduct'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OutInProduct $outInProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, OutInProduct $outInProduct)
    {
        $this->authorize('update', $outInProduct);

        $stockCards = StockCard::orderBy('date', 'asc')
            ->where('date', '>', Carbon::now()->subDays(2)->toDateString())
            ->get()
            ->pluck('stock_card_name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.out_in_products.edit',
            compact('outInProduct', 'stockCards', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\OutInProductUpdateRequest $request
     * @param \App\Models\OutInProduct $outInProduct
     * @return \Illuminate\Http\Response
     */
    public function update(
        OutInProductUpdateRequest $request,
        OutInProduct $outInProduct
    ) {
        $this->authorize('update', $outInProduct);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $outInProduct->delete_image();
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
                ->hasRole('super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $outInProduct->update($validated);

        return redirect()
            ->route('out-in-products.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OutInProduct $outInProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, OutInProduct $outInProduct)
    {
        $this->authorize('delete', $outInProduct);

        if ($outInProduct->image) {
            Storage::delete($outInProduct->image);
        }

        $outInProduct->delete();

        return redirect()
            ->route('out-in-products.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
