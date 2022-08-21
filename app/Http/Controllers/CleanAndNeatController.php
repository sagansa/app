<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\CleanAndNeat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CleanAndNeatStoreRequest;
use App\Http\Requests\CleanAndNeatUpdateRequest;

class CleanAndNeatController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', CleanAndNeat::class);

        $search = $request->get('search', '');

        // $cleanAndNeats = CleanAndNeat::search($search)
        //     ->latest()
        //     ->paginate(10)
        //     ->withQueryString();

        if(Auth::user()->hasRole('supervisor|staff|manager')) {
            $cleanAndNeats = CleanAndNeat::search($search)
                ->where('created_by_id', '=', Auth::user()->id)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } elseif (Auth::user()->hasRole('super-admin')) {
            $cleanAndNeats = CleanAndNeat::search($search)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view(
            'app.clean_and_neats.index',
            compact('cleanAndNeats', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $users = User::orderBy('name', 'asc')
            ->pluck('name', 'id');

        return view('app.clean_and_neats.create', compact('users', 'users'));
    }

    /**
     * @param \App\Http\Requests\CleanAndNeatStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CleanAndNeatStoreRequest $request)
    {
        $this->authorize('create', CleanAndNeat::class);

        $validated = $request->validated();

        // if ($request->hasFile('left_hand')) {
        //     $validated['left_hand'] = $request
        //         ->file('left_hand')
        //         ->store('public');
        // }

        if ($request->hasFile('left_hand')) {
            $file = $request->file('left_hand');
            $extension = $file->getClientOriginalExtension();
            $fileleft_hand = rand() . time() . '.' . $extension;
            $file->move('public/', $fileleft_hand);
            Image::make('public/' . $fileleft_hand)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['left_hand'] = $fileleft_hand;
        }

        if ($request->hasFile('right_hand')) {
            $file = $request->file('right_hand');
            $extension = $file->getClientOriginalExtension();
            $fileright_hand = rand() . time() . '.' . $extension;
            $file->move('storage/', $fileright_hand);
            Image::make('storage/' . $fileright_hand)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['right_hand'] = $fileright_hand;
        }

        $validated['created_by_id'] = auth()->user()->id;
        $validated['status'] = '1';

        $cleanAndNeat = CleanAndNeat::create($validated);

        return redirect()
            ->route('clean-and-neats.edit', $cleanAndNeat)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CleanAndNeat $cleanAndNeat
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, CleanAndNeat $cleanAndNeat)
    {
        $this->authorize('view', $cleanAndNeat);

        return view('app.clean_and_neats.show', compact('cleanAndNeat'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CleanAndNeat $cleanAndNeat
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, CleanAndNeat $cleanAndNeat)
    {
        $this->authorize('update', $cleanAndNeat);

        $users = User::orderBy('name', 'asc')
            ->pluck('name', 'id');

        return view(
            'app.clean_and_neats.edit',
            compact('cleanAndNeat', 'users', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\CleanAndNeatUpdateRequest $request
     * @param \App\Models\CleanAndNeat $cleanAndNeat
     * @return \Illuminate\Http\Response
     */
    public function update(
        CleanAndNeatUpdateRequest $request,
        CleanAndNeat $cleanAndNeat
    ) {
        $this->authorize('update', $cleanAndNeat);

        $validated = $request->validated();
        if ($request->hasFile('left_hand')) {
            $file = $request->file('left_hand');
            $cleanAndNeat->delete_left_hand();
            $extension = $file->getClientOriginalExtension();
            $file_left_hand = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_left_hand);
            Image::make('storage/' . $file_left_hand)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['left_hand'] = $file_left_hand;
        }

        if ($request->hasFile('right_hand')) {
            $file = $request->file('right_hand');
            $cleanAndNeat->delete_right_hand();
            $extension = $file->getClientOriginalExtension();
            $file_right_hand = rand() . time() . '.' . $extension;
            $file->move('storage/', $file_right_hand);
            Image::make('storage/' . $file_right_hand)
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save();

            $validated['right_hand'] = $file_right_hand;
        }

        if (
            auth()
                ->user()
                ->hasRole('super-admin')
        ) {
            $validated['approved_by_id'] = auth()->user()->id;
        }

        $cleanAndNeat->update($validated);

        return redirect()
            ->route('clean-and-neats.index')
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CleanAndNeat $cleanAndNeat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CleanAndNeat $cleanAndNeat)
    {
        $this->authorize('delete', $cleanAndNeat);

        if ($cleanAndNeat->left_hand) {
            Storage::delete($cleanAndNeat->left_hand);
        }

        if ($cleanAndNeat->right_hand) {
            Storage::delete($cleanAndNeat->right_hand);
        }

        $cleanAndNeat->delete();

        return redirect()
            ->route('clean-and-neats.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
