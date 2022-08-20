<?php

namespace App\Http\Livewire;

use Image;
use Illuminate\Support\Str;
use App\Models\User;
use Livewire\Component;
use App\Models\Product;
use App\Models\StoreAsset;
use Livewire\WithPagination;
use App\Models\MovementAsset;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StoreAssetMovementAssetsDetail extends Component
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
    ];

    public function mount(StoreAsset $storeAsset)
    {
        $this->storeAsset = $storeAsset;
        $this->productsForSelect = Product::pluck('name', 'id');
        $this->usersForSelect = User::pluck('name', 'id');
        $this->resetMovementAssetData();
    }

    public function resetMovementAssetData()
    {
        $this->movementAsset = new MovementAsset();

        $this->movementAssetImage = null;
        $this->movementAssetQrCode = null;
        $this->movementAsset->product_id = null;
        $this->movementAsset->user_id = 'auth()->user()->id';

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
        } else {
            $this->authorize('update', $this->movementAsset);
        }

        if ($this->movementAssetImage) {
            // $this->movementAsset->image = $this->movementAssetImage->store(
            //     'public'
            // );

            $image = $this->movementAssetImage;
            $imageName = Str::random() . '.' . $image->getClientOriginalExtension();
            $imageImg = Image::make($image->getRealPath())->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg', 65);
            $imageImg->stream();
            Storage::disk('public')->put('images/movement-assets' . '/' . $imageName, $imageImg);

            $this->movementAsset->image = $imageName;
        }

        if ($this->movementAssetQrCode) {
            // $this->movementAsset->qr_code = $this->movementAssetQrCode->store(
            //     'public'
            // );

            $qrCode = $this->movementAssetQrCode;
            $qrCodeName = Str::random() . '.' . $qrCode->getClientOriginalExtension();
            $qrCodeImg = Image::make($qrCode->getRealPath())->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg');
            $qrCodeImg->stream();
            Storage::disk('public')->put('images/movement-assets' . '/' . $qrCodeName, $qrCodeImg);

            $this->movementAsset->qr_code = $qrCodeName;
        }

        $this->movementAsset->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', MovementAsset::class);

        collect($this->selected)->each(function (string $id) {
            $movementAsset = MovementAsset::findOrFail($id);

            if ($movementAsset->image) {
                Storage::disk('public')->delete('images/movement-assets' . '/' . $movementAsset->image);
            }

            if ($movementAsset->qr_code) {
                Storage::disk('public')->delete('images/movement-assets' . '/' . $movementAsset->qr_code);
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
        return view('livewire.store-asset-movement-assets-detail', [
            'movementAssets' => $this->storeAsset
                ->movementAssets()
                ->paginate(20),
        ]);
    }
}
