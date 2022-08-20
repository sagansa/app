<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Store;
use App\Models\Hygiene;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\HygieneStoreRequest;
use App\Http\Requests\HygieneUpdateRequest;

class HygieneController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Hygiene::class);

        $search = $request->get('search', '');

        // $hygienes = Hygiene::search($search)
        //     ->latest()
        //     ->paginate(10)
        //     ->withQueryString();

        if(Auth::user()->hasRole('supervisor')) {
            $hygienes = Hygiene::search($search)
                ->where('approved_by_id', '=', Auth::user()->id)
                ->orWhere('approved_by_id', '=', NULL)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } elseif (Auth::user()->hasRole('super-admin|manager')) {
            $hygienes = Hygiene::search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } else if (Auth::user()->hasRole('staff')) {
            $hygienes = Hygiene::search($search)
                ->where('created_by_id', '=', Auth::user()->id)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view('app.hygienes.index', compact('hygienes', 'search'));
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
            ->pluck('name', 'id');

        return view('app.hygienes.create', compact('stores', 'users', 'users'));
    }

    /**
     * @param \App\Http\Requests\HygieneStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(HygieneStoreRequest $request)
    {
        $this->authorize('create', Hygiene::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $hygiene = Hygiene::create($validated);

        return redirect()
            ->route('hygienes.edit', $hygiene)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Hygiene $hygiene
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Hygiene $hygiene)
    {
        $this->authorize('view', $hygiene);

        return view('app.hygienes.show', compact('hygiene'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Hygiene $hygiene
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Hygiene $hygiene)
    {
        $this->authorize('update', $hygiene);

        $stores = Store::orderBy('nickname', 'asc')
            ->whereNotIn('status', ['8'])
            ->pluck('nickname', 'id');
        $users = User::orderBy('name', 'asc')
            ->pluck('name', 'id');

        return view(
            'app.hygienes.edit',
            compact('hygiene', 'stores', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\HygieneUpdateRequest $request
     * @param \App\Models\Hygiene $hygiene
     * @return \Illuminate\Http\Response
     */
    public function update(HygieneUpdateRequest $request, Hygiene $hygiene)
    {
        $this->authorize('update', $hygiene);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $hygiene->update($validated);

        return redirect()
            ->route('hygienes.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Hygiene $hygiene
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Hygiene $hygiene)
    {
        $this->authorize('delete', $hygiene);

        $hygiene->delete();

        return redirect()
            ->route('hygienes.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
