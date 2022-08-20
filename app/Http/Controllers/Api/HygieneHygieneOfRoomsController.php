<?php

namespace App\Http\Controllers\Api;

use App\Models\Hygiene;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HygieneOfRoomResource;
use App\Http\Resources\HygieneOfRoomCollection;

class HygieneHygieneOfRoomsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Hygiene $hygiene
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Hygiene $hygiene)
    {
        $this->authorize('view', $hygiene);

        $search = $request->get('search', '');

        $hygieneOfRooms = $hygiene
            ->hygieneOfRooms()
            ->search($search)
            ->latest()
            ->paginate();

        return new HygieneOfRoomCollection($hygieneOfRooms);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Hygiene $hygiene
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Hygiene $hygiene)
    {
        $this->authorize('create', HygieneOfRoom::class);

        $validated = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'image' => ['nullable', 'image', 'max:1024'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $hygieneOfRoom = $hygiene->hygieneOfRooms()->create($validated);

        return new HygieneOfRoomResource($hygieneOfRoom);
    }
}
