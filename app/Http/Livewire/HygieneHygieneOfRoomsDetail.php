<?php

namespace App\Http\Livewire;

use Image;
use Illuminate\Support\Str;
use App\Models\Room;
use Livewire\Component;
use App\Models\Hygiene;
use Livewire\WithPagination;
use App\Models\HygieneOfRoom;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HygieneHygieneOfRoomsDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public Hygiene $hygiene;
    public HygieneOfRoom $hygieneOfRoom;
    public $roomsForSelect = [];
    public $hygieneOfRoomImage;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New HygieneOfRoom';

    protected $rules = [
        'hygieneOfRoom.room_id' => ['required', 'exists:rooms,id'],
        'hygieneOfRoomImage' => ['nullable', 'image'],
    ];

    public function mount(Hygiene $hygiene)
    {
        $this->hygiene = $hygiene;
        $this->roomsForSelect = Room::orderBy('name', 'asc')->pluck('id', 'name');
        $this->resetHygieneOfRoomData();
    }

    public function resetHygieneOfRoomData()
    {
        $this->hygieneOfRoom = new HygieneOfRoom();

        $this->hygieneOfRoomImage = null;
        $this->hygieneOfRoom->room_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newHygieneOfRoom()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.hygiene_hygiene_of_rooms.new_title');
        $this->resetHygieneOfRoomData();

        $this->showModal();
    }

    public function editHygieneOfRoom(HygieneOfRoom $hygieneOfRoom)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.hygiene_hygiene_of_rooms.edit_title');
        $this->hygieneOfRoom = $hygieneOfRoom;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        if (!$this->hygieneOfRoom->hygiene_id) {
            $this->authorize('create', Hygiene::class);

            $this->hygieneOfRoom->hygiene_id = $this->hygiene->id;
        } else {
            $this->authorize('update', $this->hygieneOfRoom);

            if ($this->hygieneOfRoom->image) {
                Storage::disk('public')->delete('images/hygienes' . '/' . $this->hygieneOfRoom->image);
            }
        }

        if ($this->hygieneOfRoomImage) {
            // $this->hygieneOfRoom->image = $this->hygieneOfRoomImage->store(
            //     'public'
            // );

            $image = $this->hygieneOfRoomImage;
            $imageName = Str::random() . '.' . $image->getClientOriginalExtension();
            $imageImg = Image::make($image->getRealPath())->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg', 65);
            $imageImg->stream();
            Storage::disk('public')->put('images/hygienes' . '/' . $imageName, $imageImg);

            $this->hygieneOfRoom->image = $imageName;

        }

        $this->hygieneOfRoom->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Hygiene::class);

        collect($this->selected)->each(function (string $id) {
            $hygieneOfRoom = HygieneOfRoom::findOrFail($id);

            if ($hygieneOfRoom->image) {
                Storage::disk('public')->delete('images/hygienes' . '/' . $hygieneOfRoom->image);
            }

            $hygieneOfRoom->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetHygieneOfRoomData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->hygiene->hygieneOfRooms as $hygieneOfRoom) {
            array_push($this->selected, $hygieneOfRoom->id);
        }
    }

    public function render()
    {
        return view('livewire.hygiene-hygiene-of-rooms-detail', [
            'hygieneOfRooms' => $this->hygiene->hygieneOfRooms()->paginate(20),
        ]);
    }
}
