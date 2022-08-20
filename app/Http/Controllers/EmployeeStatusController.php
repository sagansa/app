<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use App\Models\EmployeeStatus;
use Illuminate\Support\Facades\Auth;
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
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.employee_statuses.index',
            compact('employeeStatuses', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.employee_statuses.create');
    }

    /**
     * @param \App\Http\Requests\EmployeeStatusStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeStatusStoreRequest $request)
    {
        $this->authorize('create', EmployeeStatus::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $employeeStatus = EmployeeStatus::create($validated);

        return redirect()
            ->route('employee-statuses.edit', $employeeStatus)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EmployeeStatus $employeeStatus
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, EmployeeStatus $employeeStatus)
    {
        $this->authorize('view', $employeeStatus);

        return view('app.employee_statuses.show', compact('employeeStatus'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\EmployeeStatus $employeeStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, EmployeeStatus $employeeStatus)
    {
        $this->authorize('update', $employeeStatus);

        return view('app.employee_statuses.edit', compact('employeeStatus'));
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

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $employeeStatus->update($validated);

        return redirect()
            ->route('employee-statuses.index')
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('employee-statuses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
