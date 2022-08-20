<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\AdminCashless;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCashlessResource;
use App\Http\Resources\UserCashlessCollection;

class AdminCashlessUserCashlessesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AdminCashless $adminCashless
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, AdminCashless $adminCashless)
    {
        $this->authorize('view', $adminCashless);

        $search = $request->get('search', '');

        $userCashlesses = $adminCashless
            ->userCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCashlessCollection($userCashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AdminCashless $adminCashless
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AdminCashless $adminCashless)
    {
        $this->authorize('create', UserCashless::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'email' => ['nullable', 'email'],
            'username' => ['nullable', 'max:50', 'string'],
            'no_telp' => ['nullable', 'max:255', 'string'],
            'password' => ['nullable'],
        ]);

        $userCashless = $adminCashless->userCashlesses()->create($validated);

        return new UserCashlessResource($userCashless);
    }
}
