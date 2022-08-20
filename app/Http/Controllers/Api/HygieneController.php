<?php

namespace App\Http\Controllers\Api;

use App\Models\Hygiene;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HygieneResource;
use App\Http\Resources\HygieneCollection;
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

        $hygienes = Hygiene::search($search)
            ->latest()
            ->paginate();

        return new HygieneCollection($hygienes);
    }

    /**
     * @param \App\Http\Requests\HygieneStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(HygieneStoreRequest $request)
    {
        $this->authorize('create', Hygiene::class);

        $validated = $request->validated();

        $hygiene = Hygiene::create($validated);

        return new HygieneResource($hygiene);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Hygiene $hygiene
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Hygiene $hygiene)
    {
        $this->authorize('view', $hygiene);

        return new HygieneResource($hygiene);
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

        $hygiene->update($validated);

        return new HygieneResource($hygiene);
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

        return response()->noContent();
    }
}
