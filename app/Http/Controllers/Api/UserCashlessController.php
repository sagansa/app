<?php

namespace App\Http\Controllers\Api;

use App\Models\UserCashless;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCashlessResource;
use App\Http\Resources\UserCashlessCollection;
use App\Http\Requests\UserCashlessStoreRequest;
use App\Http\Requests\UserCashlessUpdateRequest;

class UserCashlessController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', UserCashless::class);

        $search = $request->get('search', '');

        $userCashlesses = UserCashless::search($search)
            ->latest()
            ->paginate();

        return new UserCashlessCollection($userCashlesses);
    }

    /**
     * @param \App\Http\Requests\UserCashlessStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCashlessStoreRequest $request)
    {
        $this->authorize('create', UserCashless::class);

        $validated = $request->validated();

        $userCashless = UserCashless::create($validated);

        return new UserCashlessResource($userCashless);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UserCashless $userCashless
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, UserCashless $userCashless)
    {
        $this->authorize('view', $userCashless);

        return new UserCashlessResource($userCashless);
    }

    /**
     * @param \App\Http\Requests\UserCashlessUpdateRequest $request
     * @param \App\Models\UserCashless $userCashless
     * @return \Illuminate\Http\Response
     */
    public function update(
        UserCashlessUpdateRequest $request,
        UserCashless $userCashless
    ) {
        $this->authorize('update', $userCashless);

        $validated = $request->validated();

        $userCashless->update($validated);

        return new UserCashlessResource($userCashless);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UserCashless $userCashless
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, UserCashless $userCashless)
    {
        $this->authorize('delete', $userCashless);

        $userCashless->delete();

        return response()->noContent();
    }
}
