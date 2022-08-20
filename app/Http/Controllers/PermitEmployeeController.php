<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PermitEmployee;
use Illuminate\Support\Facades\Auth;
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

        // $permitEmployees = PermitEmployee::search($search)
        //     ->latest()
        //     ->paginate(10)
        //     ->withQueryString();
        
        if(Auth::user()->hasRole('supervisor|staff|manager')) {
            $permitEmployees = PermitEmployee::search($search)
                ->where('created_by_id', '=', Auth::user()->id)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } elseif (Auth::user()->hasRole('super-admin')) {
            $permitEmployees = PermitEmployee::search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view(
            'app.permit_employees.index',
            compact('permitEmployees', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view('app.permit_employees.create', compact('users', 'users'));
    }

    /**
     * @param \App\Http\Requests\PermitEmployeeStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermitEmployeeStoreRequest $request)
    {
        $this->authorize('create', PermitEmployee::class);

        $validated = $request->validated();

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $permitEmployee = PermitEmployee::create($validated);

        return redirect()
            ->route('permit-employees.edit', $permitEmployee)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PermitEmployee $permitEmployee
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PermitEmployee $permitEmployee)
    {
        $this->authorize('view', $permitEmployee);

        return view('app.permit_employees.show', compact('permitEmployee'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PermitEmployee $permitEmployee
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PermitEmployee $permitEmployee)
    {
        $this->authorize('update', $permitEmployee);

        $users = User::orderBy('name', 'asc')
            // ->whereIn('status', ['1'])
            ->pluck('name', 'id');

        return view(
            'app.permit_employees.edit',
            compact('permitEmployee', 'users', 'users')
        );
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

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        if (
            auth()
                ->user()
                ->hasRole('staff') &&
            $validated['status'] == '3'
        ) {
            $validated['status'] = '4';
        }

        $permitEmployee->update($validated);

        return redirect()
            ->route('permit-employees.index')
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('permit-employees.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
