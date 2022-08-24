<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\AdminCashless;
use App\Models\AccountCashless;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountCashlessCollection;

class AdminCashlessAccountCashlessesController extends Controller
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

        $accountCashlesses = $adminCashless
            ->accountCashlesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new AccountCashlessCollection($accountCashlesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AdminCashless $adminCashless
     * @param \App\Models\AccountCashless $accountCashless
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        AdminCashless $adminCashless,
        AccountCashless $accountCashless
    ) {
        $this->authorize('update', $adminCashless);

        $adminCashless
            ->accountCashlesses()
            ->syncWithoutDetaching([$accountCashless->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AdminCashless $adminCashless
     * @param \App\Models\AccountCashless $accountCashless
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        AdminCashless $adminCashless,
        AccountCashless $accountCashless
    ) {
        $this->authorize('update', $adminCashless);

        $adminCashless->accountCashlesses()->detach($accountCashless);

        return response()->noContent();
    }
}
