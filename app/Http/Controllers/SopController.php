<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Sop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->paginate(10)
            ->withQueryString();

        return view('app.sops.index', compact('sops', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.sops.create');
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
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filefile = rand() . time() . '.' . $extension;
            $file->move('storage/', $filefile);
            Image::make('storage/' . $filefile)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['file'] = $filefile;
        }

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $sop = Sop::create($validated);

        return redirect()
            ->route('sops.edit', $sop)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sop $sop
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Sop $sop)
    {
        $this->authorize('view', $sop);

        return view('app.sops.show', compact('sop'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sop $sop
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Sop $sop)
    {
        $this->authorize('update', $sop);

        return view('app.sops.edit', compact('sop'));
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
            $file = $request->file('file');
            $sop->delete_file();
            $extension = $file->getClientOriginalExtension();
            $file_file = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_file);
            Image::make('storage/' . $file_file)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['file'] = $file_file;
        }

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $sop->update($validated);

        return redirect()
            ->route('sops.index')
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('sops.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
