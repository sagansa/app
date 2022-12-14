<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\UserCashless;
use App\Models\AdminCashless;
use App\Http\Controllers\Controller;
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
     * @param \App\Models\UserCashless $userCashless
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        AdminCashless $adminCashless,
        UserCashless $userCashless
    ) {
        $this->authorize('update', $adminCashless);

        $adminCashless
            ->userCashlesses()
            ->syncWithoutDetaching([$userCashless->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AdminCashless $adminCashless
     * @param \App\Models\UserCashless $userCashless
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        AdminCashless $adminCashless,
        UserCashless $userCashless
    ) {
        $this->authorize('update', $adminCashless);

        $adminCashless->userCashlesses()->detach($userCashless);

        return response()->noContent();
    }
}
