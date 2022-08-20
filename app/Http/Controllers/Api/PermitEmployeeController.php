<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PermitEmployee;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermitEmployeeResource;
use App\Http\Resources\PermitEmployeeCollection;
use App\Http\Requests\PermitEmployeeStoreRequest;
use App\Http\Requests\PermitEmployeeUpdateRequest;

class PermitEmployeeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', PermitEmployee::class);

        $search = $request->get('search', '');

        $permitEmployees = PermitEmployee::search($search)
            ->latest()
            ->paginate();

        return new PermitEmployeeCollection($permitEmployees);
    }

    /**
     * @param \App\Http\Requests\PermitEmployeeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermitEmployeeStoreRequest $request)
    {
        $this->authorize('create', PermitEmployee::class);

        $validated = $request->validated();

        $permitEmployee = PermitEmployee::create($validated);

        return new PermitEmployeeResource($permitEmployee);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PermitEmployee $permitEmployee
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PermitEmployee $permitEmployee)
    {
        $this->authorize('view', $permitEmployee);

        return new PermitEmployeeResource($permitEmployee);
    }

    /**
     * @param \App\Http\Requests\PermitEmployeeUpdateRequest $request
     * @param \App\Models\PermitEmployee $permitEmployee
     * @return \Illuminate\Http\Response
     */
    public function update(
        PermitEmployeeUpdateRequest $request,
        PermitEmployee $permitEmployee
    ) {
        $this->authorize('update', $permitEmployee);

        $validated = $request->validated();

        $permitEmployee->update($validated);

        return new PermitEmployeeResource($permitEmployee);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PermitEmployee $permitEmployee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PermitEmployee $permitEmployee)
    {
        $this->authorize('delete', $permitEmployee);

        $permitEmployee->delete();

        return response()->noContent();
    }
}
