<?php
namespace App\Http\Controllers\Api;

use App\Models\Presence;
use Illuminate\Http\Request;
use App\Models\TransferDailySalary;
use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceCollection;

class TransferDailySalaryPresencesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferDailySalary $transferDailySalary
     * @return \Illuminate\Http\Response
     */
    public function index(
        Request $request,
        TransferDailySalary $transferDailySalary
    ) {
        $this->authorize('view', $transferDailySalary);

        $search = $request->get('search', '');

        $presences = $transferDailySalary
            ->presences()
            ->search($search)
            ->latest()
            ->paginate();

        return new PresenceCollection($presences);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferDailySalary $transferDailySalary
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        TransferDailySalary $transferDailySalary,
        Presence $presence
    ) {
        $this->authorize('update', $transferDailySalary);

        $transferDailySalary
            ->presences()
            ->syncWithoutDetaching([$presence->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferDailySalary $transferDailySalary
     * @param \App\Models\Presence $presence
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        TransferDailySalary $transferDailySalary,
        Presence $presence
    ) {
        $this->authorize('update', $transferDailySalary);

        $transferDailySalary->presences()->detach($presence);

        return response()->noContent();
    }
}
