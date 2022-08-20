<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\EmployeeStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeStatusResource;
use App\Http\Resources\EmployeeStatusCollection;
use App\Http\Requests\EmployeeStatusStoreRequest;
use App\Http\Requests\EmployeeStatusUpdateRequest;

class EmployeeStatusController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', EmployeeStatus::class);

        $search = $request->get('search', '');

        $employeeStatuses = EmployeeStatus::search($search)
            ->latest()
            ->paginate();

        return new EmployeeStatusCollection($employeeStatuses);
    }

    /**
     * @param \App\Http\Requests\EmployeeStatusStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeStatusStoreRequest $request)
    {
        $this->authorize('create', EmployeeStatus::class);

        $validated = $request->validated();

        $employeeStatus = EmployeeStatus::create($validated);

        return new EmployeeStatusResource($employeeStatus);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EmployeeStatus $employeeStatus
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, EmployeeStatus $employeeStatus)
    {
        $this->authorize('view', $employeeStatus);

        return new EmployeeStatusResource($employeeStatus);
    }

    /**
     * @param \App\Http\Requests\EmployeeStatusUpdateRequest $request
     * @param \App\Models\EmployeeStatus $employeeStatus
     * @return \Illuminate\Http\Response
     */
    public function update(
        EmployeeStatusUpdateRequest $request,
        EmployeeStatus $employeeStatus
    ) {
        $this->authorize('update', $employeeStatus);

        $validated = $request->validated();

        $employeeStatus->update($validated);

        return new EmployeeStatusResource($employeeStatus);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EmployeeStatus $employeeStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, EmployeeStatus $employeeStatus)
    {
        $this->authorize('delete', $employeeStatus);

        $employeeStatus->delete();

        return response()->noContent();
    }
}
