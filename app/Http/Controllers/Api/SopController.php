<?php

namespace App\Http\Controllers\Api;

use App\Models\Sop;
use Illuminate\Http\Request;
use App\Http\Resources\SopResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\SopCollection;
use App\Http\Requests\SopStoreRequest;
use App\Http\Requests\SopUpdateRequest;
use Illuminate\Support\Facades\Storage;

class SopController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Sop::class);

        $search = $request->get('search', '');

        $sops = Sop::search($search)
            ->latest()
            ->paginate();

        return new SopCollection($sops);
    }

    /**
     * @param \App\Http\Requests\SopStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SopStoreRequest $request)
    {
        $this->authorize('create', Sop::class);

        $validated = $request->validated();
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('public');
        }

        $sop = Sop::create($validated);

        return new SopResource($sop);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sop $sop
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Sop $sop)
    {
        $this->authorize('view', $sop);

        return new SopResource($sop);
    }

    /**
     * @param \App\Http\Requests\SopUpdateRequest $request
     * @param \App\Models\Sop $sop
     * @return \Illuminate\Http\Response
     */
    public function update(SopUpdateRequest $request, Sop $sop)
    {
        $this->authorize('update', $sop);

        $validated = $request->validated();

        if ($request->hasFile('file')) {
            if ($sop->file) {
                Storage::delete($sop->file);
            }

            $validated['file'] = $request->file('file')->store('public');
        }

        $sop->update($validated);

        return new SopResource($sop);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sop $sop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Sop $sop)
    {
        $this->authorize('delete', $sop);

        if ($sop->file) {
            Storage::delete($sop->file);
        }

        $sop->delete();

        return response()->noContent();
    }
}
