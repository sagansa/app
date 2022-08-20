<?php
namespace App\Http\Controllers\Api;

use App\Models\Utility;
use App\Models\UtiliyUsage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtiliyUsageCollection;

class UtilityUtiliyUsagesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Utility $utility
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Utility $utility)
    {
        $this->authorize('view', $utility);

        $search = $request->get('search', '');

        $utiliyUsages = $utility
            ->utiliyUsages()
            ->search($search)
            ->latest()
            ->paginate();

        return new UtiliyUsageCollection($utiliyUsages);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Utility $utility
     * @param \App\Models\UtiliyUsage $utiliyUsage
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Utility $utility,
        UtiliyUsage $utiliyUsage
    ) {
        $this->authorize('update', $utility);

        $utility->utiliyUsages()->syncWithoutDetaching([$utiliyUsage->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Utility $utility
     * @param \App\Models\UtiliyUsage $utiliyUsage
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Utility $utility,
        UtiliyUsage $utiliyUsage
    ) {
        $this->authorize('update', $utility);

        $utility->utiliyUsages()->detach($utiliyUsage);

        return response()->noContent();
    }
}
