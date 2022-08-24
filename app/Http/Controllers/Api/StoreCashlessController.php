<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\StoreCashless;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreCashlessResource;
use App\Http\Resources\StoreCashlessCollection;
use App\Http\Requests\StoreCashlessStoreRequest;
use App\Http\Requests\StoreCashlessUpdateRequest;

class StoreCashlessController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', StoreCashless::class);

        $search = $request->get('search', '');

        $storeCashlesses = StoreCashless::search($search)
            ->latest()
            ->paginate();

        return new StoreCashlessCollection($storeCashlesses);
    }

    /**
     * @param \App\Http\Requests\StoreCashlessStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCashlessStoreRequest $request)
    {
        $this->authorize('create', StoreCashless::class);

        $validated = $request->validated();

        $storeCashless = StoreCashless::create($validated);

        return new StoreCashlessResource($storeCashless);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StoreCashless $storeCashless
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, StoreCashless $storeCashless)
    {
        $this->authorize('view', $storeCashless);

        return new StoreCashlessResource($storeCashless);
    }

    /**
     * @param \App\Http\Requests\StoreCashlessUpdateRequest $request
     * @param \App\Models\StoreCashless $storeCashless
     * @return \Illuminate\Http\Response
     */
    public function update(
        StoreCashlessUpdateRequest $request,
        StoreCashless $storeCashless
    ) {
        $this->authorize('update', $storeCashless);

        $validated = $request->validated();

        $storeCashless->update($validated);

        return new StoreCashlessResource($storeCashless);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StoreCashless $storeCashless
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, StoreCashless $storeCashless)
    {
        $this->authorize('delete', $storeCashless);

        $storeCashless->delete();

        return response()->noContent();
    }
}
