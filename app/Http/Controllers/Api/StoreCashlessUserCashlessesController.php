<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\StoreCashless;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCashlessResource;
use App\Http\Resources\UserCashlessCollection;

class StoreCashlessUserCashlessesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StoreCashless $storeCashless
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, StoreCashless $storeCashless)
    {
        $this->authorize('view', $storeCashless);

        $search = $request->get('search', '');

        $userCashlesses = $storeCashless
            ->userCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCashlessCollection($userCashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StoreCashless $storeCashless
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, StoreCashless $storeCashless)
    {
        $this->authorize('create', UserCashless::class);

        $validated = $request->validate([
            'cashless_provider_id' => [
                'required',
                'exists:cashless_providers,id',
            ],
            'store_id' => ['required', 'exists:stores,id'],
            'email' => ['nullable', 'email'],
            'username' => ['nullable', 'max:50', 'string'],
            'no_telp' => ['nullable', 'max:255', 'string'],
            'password' => ['nullable'],
            'status' => ['required', 'max:255'],
        ]);

        $userCashless = $storeCashless->userCashlesses()->create($validated);

        return new UserCashlessResource($userCashless);
    }
}
