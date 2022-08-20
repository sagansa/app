<?php
namespace App\Http\Controllers\Api;

use App\Models\Room;
use App\Models\Hygiene;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomCollection;

class HygieneRoomsController extends Controller
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

        $rooms = $hygiene
            ->rooms()
            ->search($search)
            ->latest()
            ->paginate();

        return new RoomCollection($rooms);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Hygiene $hygiene
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Hygiene $hygiene, Room $room)
    {
        $this->authorize('update', $hygiene);

        $hygiene->rooms()->syncWithoutDetaching([$room->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Hygiene $hygiene
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Hygiene $hygiene, Room $room)
    {
        $this->authorize('update', $hygiene);

        $hygiene->rooms()->detach($room);

        return response()->noContent();
    }
}
