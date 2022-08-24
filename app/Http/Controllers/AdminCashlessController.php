<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use App\Models\AdminCashless;
use App\Models\CashlessProvider;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminCashlessStoreRequest;
use App\Http\Requests\AdminCashlessUpdateRequest;

class AdminCashlessController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', AdminCashless::class);

        $search = $request->get('search', '');

        $adminCashlesses = AdminCashless::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.admin_cashlesses.index',
            compact('adminCashlesses', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $cashlessProviders = CashlessProvider::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.admin_cashlesses.create',
            compact('cashlessProviders')
        );
    }

    /**
     * @param \App\Http\Requests\AdminCashlessStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCashlessStoreRequest $request)
    {
        $this->authorize('create', AdminCashless::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $adminCashless = AdminCashless::create($validated);

        return redirect()
            ->route('admin-cashlesses.edit', $adminCashless)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AdminCashless $adminCashless
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AdminCashless $adminCashless)
    {
        $this->authorize('view', $adminCashless);

        return view('app.admin_cashlesses.show', compact('adminCashless'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AdminCashless $adminCashless
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, AdminCashless $adminCashless)
    {
        $this->authorize('update', $adminCashless);

        $cashlessProviders = CashlessProvider::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.admin_cashlesses.edit',
            compact('adminCashless', 'cashlessProviders')
        );
    }

    /**
     * @param \App\Http\Requests\AdminCashlessUpdateRequest $request
     * @param \App\Models\AdminCashless $adminCashless
     * @return \Illuminate\Http\Response
     */
    public function update(
        AdminCashlessUpdateRequest $request,
        AdminCashless $adminCashless
    ) {
        $this->authorize('update', $adminCashless);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $adminCashless->update($validated);

        return redirect()
            ->route('admin-cashlesses.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AdminCashless $adminCashless
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AdminCashless $adminCashless)
    {
        $this->authorize('delete', $adminCashless);

        $adminCashless->delete();

        return redirect()
            ->route('admin-cashlesses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
