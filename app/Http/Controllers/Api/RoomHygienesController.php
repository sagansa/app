<?php
namespace App\Http\Controllers\Api;

use App\Models\Room;
use App\Models\Hygiene;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HygieneCollection;

class RoomHygienesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Room $room)
    {
        $this->authorize('view', $room);

        $search = $request->get('search', '');

        $hygienes = $room
            ->hygienes()
            ->search($search)
            ->latest()
            ->paginate();

        return new HygieneCollection($hygienes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Room $room
     * @param \App\Models\Hygiene $hygiene
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Room $room, Hygiene $hygiene)
    {
        $this->authorize('update', $room);

        $room->hygienes()->syncWithoutDetaching([$hygiene->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Room $room
     * @param \App\Models\Hygiene $hygiene
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Room $room, Hygiene $hygiene)
    {
        $this->authorize('update', $room);

        $room->hygienes()->detach($hygiene);

        return response()->noContent();
    }
}
