<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\AccountCashless;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AccountCashlessResource;
use App\Http\Resources\AccountCashlessCollection;
use App\Http\Requests\AccountCashlessStoreRequest;
use App\Http\Requests\AccountCashlessUpdateRequest;

class AccountCashlessController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', AccountCashless::class);

        $search = $request->get('search', '');

        $accountCashlesses = AccountCashless::search($search)
            ->latest()
            ->paginate();

        return new AccountCashlessCollection($accountCashlesses);
    }

    /**
     * @param \App\Http\Requests\AccountCashlessStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountCashlessStoreRequest $request)
    {
        $this->authorize('create', AccountCashless::class);

        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $accountCashless = AccountCashless::create($validated);

        return new AccountCashlessResource($accountCashless);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AccountCashless $accountCashless
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AccountCashless $accountCashless)
    {
        $this->authorize('view', $accountCashless);

        return new AccountCashlessResource($accountCashless);
    }

    /**
     * @param \App\Http\Requests\AccountCashlessUpdateRequest $request
     * @param \App\Models\AccountCashless $accountCashless
     * @return \Illuminate\Http\Response
     */
    public function update(
        AccountCashlessUpdateRequest $request,
        AccountCashless $accountCashless
    ) {
        $this->authorize('update', $accountCashless);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $accountCashless->update($validated);

        return new AccountCashlessResource($accountCashless);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AccountCashless $accountCashless
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AccountCashless $accountCashless)
    {
        $this->authorize('delete', $accountCashless);

        $accountCashless->delete();

        return response()->noContent();
    }
}
