<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\AdminCashless;
use App\Models\AccountCashless;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminCashlessCollection;

class AccountCashlessAdminCashlessesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AccountCashless $accountCashless
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, AccountCashless $accountCashless)
    {
        $this->authorize('view', $accountCashless);

        $search = $request->get('search', '');

        $adminCashlesses = $accountCashless
            ->adminCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new AdminCashlessCollection($adminCashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AccountCashless $accountCashless
     * @param \App\Models\AdminCashless $adminCashless
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        AccountCashless $accountCashless,
        AdminCashless $adminCashless
    ) {
        $this->authorize('update', $accountCashless);

        $accountCashless
            ->adminCashlesses()
            ->syncWithoutDetaching([$adminCashless->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AccountCashless $accountCashless
     * @param \App\Models\AdminCashless $adminCashless
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        AccountCashless $accountCashless,
        AdminCashless $adminCashless
    ) {
        $this->authorize('update', $accountCashless);

        $accountCashless->adminCashlesses()->detach($adminCashless);

        return response()->noContent();
    }
}
