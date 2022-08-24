<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\UserCashless;
use App\Models\AdminCashless;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminCashlessCollection;

class UserCashlessAdminCashlessesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UserCashless $userCashless
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, UserCashless $userCashless)
    {
        $this->authorize('view', $userCashless);

        $search = $request->get('search', '');

        $adminCashlesses = $userCashless
            ->adminCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new AdminCashlessCollection($adminCashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UserCashless $userCashless
     * @param \App\Models\AdminCashless $adminCashless
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        UserCashless $userCashless,
        AdminCashless $adminCashless
    ) {
        $this->authorize('update', $userCashless);

        $userCashless
            ->adminCashlesses()
            ->syncWithoutDetaching([$adminCashless->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\UserCashless $userCashless
     * @param \App\Models\AdminCashless $adminCashless
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        UserCashless $userCashless,
        AdminCashless $adminCashless
    ) {
        $this->authorize('update', $userCashless);

        $userCashless->adminCashlesses()->detach($adminCashless);

        return response()->noContent();
    }
}
