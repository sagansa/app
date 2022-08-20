<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RequestStockResource;
use App\Http\Resources\RequestStockCollection;

class UserRequestStocksController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $requestStocks = $user
            ->requestStocksApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new RequestStockCollection($requestStocks);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', RequestStock::class);

        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
        ]);

        $requestStock = $user->requestStocksApproved()->create($validated);

        return new RequestStockResource($requestStock);
    }
}
