<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use App\Models\OnlineCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OnlineCategoryStoreRequest;
use App\Http\Requests\OnlineCategoryUpdateRequest;

class OnlineCategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', OnlineCategory::class);

        $search = $request->get('search', '');

        $onlineCategories = OnlineCategory::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.online_categories.index',
            compact('onlineCategories', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.online_categories.create');
    }

    /**
     * @param \App\Http\Requests\OnlineCategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OnlineCategoryStoreRequest $request)
    {
        $this->authorize('create', OnlineCategory::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $onlineCategory = OnlineCategory::create($validated);

        return redirect()
            ->route('online-categories.edit', $onlineCategory)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OnlineCategory $onlineCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, OnlineCategory $onlineCategory)
    {
        $this->authorize('view', $onlineCategory);

        return view('app.online_categories.show', compact('onlineCategory'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OnlineCategory $onlineCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, OnlineCategory $onlineCategory)
    {
        $this->authorize('update', $onlineCategory);

        return view('app.online_categories.edit', compact('onlineCategory'));
    }

    /**
     * @param \App\Http\Requests\OnlineCategoryUpdateRequest $request
     * @param \App\Models\OnlineCategory $onlineCategory
     * @return \Illuminate\Http\Response
     */
    public function update(
        OnlineCategoryUpdateRequest $request,
        OnlineCategory $onlineCategory
    ) {
        $this->authorize('update', $onlineCategory);

        $validated = $request->validated();

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $onlineCategory->update($validated);

        return redirect()
            ->route('online-categories.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OnlineCategory $onlineCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, OnlineCategory $onlineCategory)
    {
        $this->authorize('delete', $onlineCategory);

        $onlineCategory->delete();

        return redirect()
            ->route('online-categories.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
