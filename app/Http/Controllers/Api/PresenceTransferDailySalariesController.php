<?php
namespace App\Http\Controllers\Api;

use App\Models\Presence;
use Illuminate\Http\Request;
use App\Models\TransferDailySalary;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransferDailySalaryCollection;

class PresenceTransferDailySalariesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Presence $presence)
    {
        $this->authorize('view', $presence);

        $search = $request->get('search', '');

        $transferDailySalaries = $presence
            ->transferDailySalaries()
            ->search($search)
            ->latest()
            ->paginate();

        return new TransferDailySalaryCollection($transferDailySalaries);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @param \App\Models\TransferDailySalary $transferDailySalary
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Presence $presence,
        TransferDailySalary $transferDailySalary
    ) {
        $this->authorize('update', $presence);

        $presence
            ->transferDailySalaries()
            ->syncWithoutDetaching([$transferDailySalary->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Presence $presence
     * @param \App\Models\TransferDailySalary $transferDailySalary
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Presence $presence,
        TransferDailySalary $transferDailySalary
    ) {
        $this->authorize('update', $presence);

        $presence->transferDailySalaries()->detach($transferDailySalary);

        return response()->noContent();
    }
}
