<?php

namespace App\Http\Livewire\StoreAssets;

use Image;
use App\Models\MovementAsset;
use App\Models\Product;
use App\Models\StoreAsset;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class StoreAssetsList extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public StoreAsset $storeAsset;
    public MovementAsset $movementAsset;
    public $productsForSelect = [];
    public $usersForSelect = [];
    public $movementAssetImage;
    public $movementAssetQrCode;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New MovementAsset';

    protected $rules = [
        'movementAssetImage' => ['nullable', 'image'],
        'movementAssetQrCode' => ['image', 'nullable'],
        'movementAsset.product_id' => ['required', 'exists:products,id'],
        'movementAsset.good_cond_qty' => ['required', 'numeric'],
        'movementAsset.bad_cond_qty' => ['required', 'numeric'],
        'movementAsset.user_id' => ['nullable', 'exists:users,id'],
    ];

    public function mount(StoreAsset $storeAsset)
    {
        $this->storeAsset = $storeAsset;
        $this->productsForSelect = Product::orderBy('name','asc')->get()->pluck('product_name', 'id');
        $this->usersForSelect = User::pluck('name', 'id');
        $this->resetMovementAssetData();

        if ($this->storeAsset->exists) {
            $this->image = $this->storeAsset->getFirstMediaUrl('post_image');
        }
    }

    public function resetMovementAssetData()
    {
        $this->movementAsset = new MovementAsset();

        $this->movementAssetImage = null;
        $this->movementAssetQrCode = null;
        $this->movementAsset->product_id = null;
        $this->movementAsset->user_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newMovementAsset()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.store_asset_movement_assets.new_title');
        $this->resetMovementAssetData();

        $this->showModal();
    }

    public function editMovementAsset(MovementAsset $movementAsset)
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.store_asset_movement_assets.edit_title'
        );
        $this->movementAsset = $movementAsset;

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

        if (!$this->movementAsset->store_asset_id) {
            $this->authorize('create', MovementAsset::class);

            $this->movementAsset->store_asset_id = $this->storeAsset->id;
            $this->movementAsset->user_id = auth()->user()->id;
        } else {
            $this->authorize('update', $this->movementAsset);
        }

        if ($this->movementAssetImage) {
             $this->movementAsset->image = $this->movementAssetImage->store(
                'public'
            );

            // $img = ImageManagerStatic::make($this->movementAssetImage)
            //     ->resize(400, 400, function ($constraint) {
            //         $constraint->aspectRatio();
            //         $constraint->upsize();
            //     })
            //     ->encode('jpg');
            // $name  = Str::random() . '.jpg';
            // Storage::disk('public')->put($name, $img);

            // $this->movementAsset->image = 'public/' . $name;
        }
        
        if ($this->movementAssetQrCode) {
            $this->movementAsset->qr_code = $this->movementAssetQrCode->store(
                'public'
            );

            // $img = ImageManagerStatic::make($this->movementAssetQrCode)
            //     ->resize(400, 400, function ($constraint) {
            //         $constraint->aspectRatio();
            //         $constraint->upsize();
            //     })
            //     ->encode('jpg');
            // $name  = Str::random() . '.jpg';
            // Storage::disk('public')->put($name, $img);

            // $this->movementAsset->qr_code = 'public/' .$name;
        }

        $this->movementAsset->save();

        $this->movementAsset->clearMediaCollection('image');
        $this->movementAsset->addMedia($this->image->getRealPath())->toMediaCollection('image');

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', MovementAsset::class);

        collect($this->selected)->each(function (string $id) {
            $movementAsset = MovementAsset::findOrFail($id);

            if ($movementAsset->image) {
                Storage::delete($movementAsset->image);
            }

            if ($movementAsset->qr_code) {
                Storage::delete($movementAsset->qr_code);
            }

            $movementAsset->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetMovementAssetData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->storeAsset->movementAssets as $movementAsset) {
            array_push($this->selected, $movementAsset->id);
        }
    }

    public function render()
    {
        return view('livewire.store-assets.store-assets-list', [
            'movementAssets' => $this->storeAsset
                ->movementAssets()
                ->paginate(20),
        ]);
    }

    public function upload(){
        $this->validate([
            'image' => 'image|max:3000', // 1MB Max
        ]);
       $path = $this->image->store("temp","public");
        
        Image::make($this->image)
        ->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })
        ->save(storage_path()."/app/public/raw/first.jpg");
    }
}
