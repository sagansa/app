<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use App\Models\TransferDailySalary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TransferDailySalaryStoreRequest;
use App\Http\Requests\TransferDailySalaryUpdateRequest;

class TransferDailySalaryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', TransferDailySalary::class);

        $search = $request->get('search', '');

        $transferDailySalaries = TransferDailySalary::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'app.transfer_daily_salaries.index',
            compact('transferDailySalaries', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('app.transfer_daily_salaries.create');
    }

    /**
     * @param \App\Http\Requests\TransferDailySalaryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransferDailySalaryStoreRequest $request)
    {
        $this->authorize('create', TransferDailySalary::class);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileimage = rand() . time() . '.' . $extension;
            $file->move('storage/', $fileimage);
            Image::make('storage/' . $fileimage)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image'] = $fileimage;
        }

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $transferDailySalary = TransferDailySalary::create($validated);

        return redirect()
            ->route('transfer-daily-salaries.edit', $transferDailySalary)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferDailySalary $transferDailySalary
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        TransferDailySalary $transferDailySalary
    ) {
        $this->authorize('view', $transferDailySalary);

        return view(
            'app.transfer_daily_salaries.show',
            compact('transferDailySalary')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferDailySalary $transferDailySalary
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        TransferDailySalary $transferDailySalary
    ) {
        $this->authorize('update', $transferDailySalary);

        return view(
            'app.transfer_daily_salaries.edit',
            compact('transferDailySalary')
        );
    }

    /**
     * @param \App\Http\Requests\TransferDailySalaryUpdateRequest $request
     * @param \App\Models\TransferDailySalary $transferDailySalary
     * @return \Illuminate\Http\Response
     */
    public function update(
        TransferDailySalaryUpdateRequest $request,
        TransferDailySalary $transferDailySalary
    ) {
        $this->authorize('update', $transferDailySalary);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $transferDailySalary->delete_image();
            $extension = $file->getClientOriginalExtension();
            $file_image = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_image);
            Image::make('storage/' . $file_image)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['image'] = $file_image;
        }

        if (
            auth()
                ->user()
                ->hasRole('supervisor|manager|super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $transferDailySalary->update($validated);

        return redirect()
            ->route('transfer-daily-salaries.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TransferDailySalary $transferDailySalary
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        TransferDailySalary $transferDailySalary
    ) {
        $this->authorize('delete', $transferDailySalary);

        if ($transferDailySalary->image) {
            Storage::delete($transferDailySalary->image);
        }

        $transferDailySalary->delete();

        return redirect()
            ->route('transfer-daily-salaries.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
