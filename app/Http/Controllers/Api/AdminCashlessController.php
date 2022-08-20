<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\AdminCashless;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminCashlessResource;
use App\Http\Resources\AdminCashlessCollection;
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
            ->paginate();

        return new AdminCashlessCollection($adminCashlesses);
    }

    /**
     * @param \App\Http\Requests\AdminCashlessStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCashlessStoreRequest $request)
    {
        $this->authorize('create', AdminCashless::class);

        $validated = $request->validated();

        $adminCashless = AdminCashless::create($validated);

        return new AdminCashlessResource($adminCashless);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AdminCashless $adminCashless
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AdminCashless $adminCashless)
    {
        $this->authorize('view', $adminCashless);

        return new AdminCashlessResource($adminCashless);
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

        $adminCashless->update($validated);

        return new AdminCashlessResource($adminCashless);
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

        return response()->noContent();
    }
}
