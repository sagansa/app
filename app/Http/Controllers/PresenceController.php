<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Presence;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Models\ClosingStore;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PresenceStoreRequest;
use App\Http\Requests\PresenceUpdateRequest;
use Carbon\Carbon;

class PresenceController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Presence::class);

        $search = $request->get('search', '');

        // $presences = Presence::search($search)
        //     ->latest()
        //     ->paginate(10)
        //     ->withQueryString();

        if(Auth::user()->hasRole('supervisor')) {
            $presences = Presence::search($search)
                ->where('approved_by_id', '=', Auth::user()->id)
                ->orWhere('approved_by_id', '=', NULL)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } elseif (Auth::user()->hasRole('super-admin|manager')) {
            $presences = Presence::search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } else if (Auth::user()->hasRole('staff')) {
            $presences = Presence::search($search)
                ->where('created_by_id', '=', Auth::user()->id)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view('app.presences.index', compact('presences', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $closingStores = ClosingStore::orderBy('date', 'asc')
        //     ->whereIn('status', ['1'])
        //     ->pluck('date', 'id');
        $paymentTypes = PaymentType::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        if(Auth::user()->hasRole('supervisor|staff|manager')) {
            $closingStores = ClosingStore::orderBy('date', 'asc')
                ->where('date', '>', Carbon::now()->subDays(7)->toDateString())
                ->get()
                ->pluck('closing_store_name', 'id');
        } else if(Auth::user()->hasRole('super-admin')) {
            $closingStores = ClosingStore::orderBy('date', 'asc')
                ->get()
                ->pluck('closing_store_name', 'id');
        }

        return view(
            'app.presences.create',
            compact('closingStores', 'paymentTypes', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\PresenceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PresenceStoreRequest $request)
    {
        $this->authorize('create', Presence::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $presence = Presence::create($validated);

        return redirect()
            ->route('presences.edit', $presence)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Presence $presence)
    {
        $this->authorize('view', $presence);

        return view('app.presences.show', compact('presence'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Presence $presence)
    {
        $this->authorize('update', $presence);

        // $closingStores = ClosingStore::orderBy('date', 'asc')
        //     ->whereIn('status', ['1'])
        //     ->pluck('date', 'id');
        $paymentTypes = PaymentType::orderBy('name', 'asc')
            ->whereIn('status', ['1'])
            ->pluck('name', 'id');
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        if(Auth::user()->hasRole('supervisor|staff|manager')) {
            $closingStores = ClosingStore::orderBy('date', 'asc')
                ->where('date', '>', Carbon::now()->subDays(7)->toDateString())
                ->get()
                ->pluck('closing_store_name', 'id');
        } else if(Auth::user()->hasRole('super-admin')) {
            $closingStores = ClosingStore::orderBy('date', 'asc')
                ->get()
                ->pluck('closing_store_name', 'id');
        }

        return view(
            'app.presences.edit',
            compact(
                'presence',
                'closingStores',
                'paymentTypes',
                'users',
                'users'
            )
        );
    }

    /**
     * @param \App\Http\Requests\PresenceUpdateRequest $request
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function update(PresenceUpdateRequest $request, Presence $presence)
    {
        $this->authorize('update', $presence);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $presence->update($validated);

        return redirect()
            ->route('presences.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Presence $presence)
    {
        $this->authorize('delete', $presence);

        $presence->delete();

        return redirect()
            ->route('presences.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
