<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermitEmployeeResource;
use App\Http\Resources\PermitEmployeeCollection;

class UserPermitEmployeesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $permitEmployees = $user
            ->permitEmployeesApproved()
            ->search($search)
            ->latest()
            ->paginate();

        return new PermitEmployeeCollection($permitEmployees);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', PermitEmployee::class);

        $validated = $request->validate([
            'reason' => ['required', 'max:255'],
            'from_date' => ['required', 'date'],
            'until_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'max:255'],
        ]);

        $permitEmployee = $user->permitEmployeesApproved()->create($validated);

        return new PermitEmployeeResource($permitEmployee);
    }
}
