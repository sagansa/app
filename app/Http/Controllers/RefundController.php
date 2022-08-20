<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\RefundStoreRequest;
use App\Http\Requests\RefundUpdateRequest;

class RefundController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Refund::class);

        $search = $request->get('search', '');

        // $refunds = Refund::search($search)
        //     ->latest()
        //     ->paginate(10)
        //     ->withQueryString();

        if(Auth::user()->hasRole('supervisor|staff|manager')) {
            $refunds = Refund::search($search)
                ->where('user_id', '=', Auth::user()->id)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } elseif (Auth::user()->hasRole('super-admin')) {
            $refunds = Refund::search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view('app.refunds.index', compact('refunds', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view('app.refunds.create', compact('users'));
    }

    /**
     * @param \App\Http\Requests\RefundStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RefundStoreRequest $request)
    {
        $this->authorize('create', Refund::class);

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

        $validated['user_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $refund = Refund::create($validated);

        return redirect()
            ->route('refunds.edit', $refund)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Refund $refund
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Refund $refund)
    {
        $this->authorize('view', $refund);

        return view('app.refunds.show', compact('refund'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Refund $refund
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Refund $refund)
    {
        $this->authorize('update', $refund);

        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view('app.refunds.edit', compact('refund', 'users'));
    }

    /**
     * @param \App\Http\Requests\RefundUpdateRequest $request
     * @param \App\Models\Refund $refund
     * @return \Illuminate\Http\Response
     */
    public function update(RefundUpdateRequest $request, Refund $refund)
    {
        $this->authorize('update', $refund);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $refund->delete_image();
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

        $refund->update($validated);

        return redirect()
            ->route('refunds.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Refund $refund
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Refund $refund)
    {
        $this->authorize('delete', $refund);

        if ($refund->image) {
            Storage::delete($refund->image);
        }

        $refund->delete();

        return redirect()
            ->route('refunds.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
