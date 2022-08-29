<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Regency;
use App\Models\Village;
use App\Models\Customer;
use App\Models\Province;
use App\Models\District;
use Livewire\WithPagination;
use App\Models\DeliveryAddress;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CustomerDeliveryAddresses extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Customer $customer;
    public DeliveryAddress $deliveryAddress;
    public $provincesForSelect = [];
    public $regenciesForSelect = [];
    public $districtsForSelect = [];
    public $villagesForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New DeliveryAddress';

    protected $rules = [
        'deliveryAddress.name' => ['required', 'max:255', 'string'],
        'deliveryAddress.recipients_name' => ['required', 'max:255', 'string'],
        'deliveryAddress.recipients_telp_no' => [
            'required',
            'max:255',
            'string',
        ],
        'deliveryAddress.address' => ['required', 'max:255', 'string'],
        'deliveryAddress.province_id' => ['nullable', 'exists:provinces,id'],
        'deliveryAddress.regency_id' => ['nullable', 'exists:regencies,id'],
        'deliveryAddress.district_id' => ['nullable', 'exists:districts,id'],
        'deliveryAddress.village_id' => ['nullable', 'exists:villages,id'],
        'deliveryAddress.codepos' => ['nullable', 'numeric'],
    ];

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
        $this->provincesForSelect = Province::pluck('name', 'id');
        $this->regenciesForSelect = Regency::pluck('name', 'id');
        $this->districtsForSelect = District::pluck('name', 'id');
        $this->villagesForSelect = Village::pluck('name', 'id');
        $this->resetDeliveryAddressData();
    }

    public function resetDeliveryAddressData()
    {
        $this->deliveryAddress = new DeliveryAddress();

        $this->deliveryAddress->province_id = null;
        $this->deliveryAddress->regency_id = null;
        $this->deliveryAddress->district_id = null;
        $this->deliveryAddress->village_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newDeliveryAddress()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.customer_delivery_addresses.new_title');
        $this->resetDeliveryAddressData();

        $this->showModal();
    }

    public function editDeliveryAddress(DeliveryAddress $deliveryAddress)
    {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.customer_delivery_addresses.edit_title'
        );
        $this->deliveryAddress = $deliveryAddress;

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

        if (!$this->deliveryAddress->customer_id) {
            $this->authorize('create', DeliveryAddress::class);

            $this->deliveryAddress->customer_id = $this->customer->id;
        } else {
            $this->authorize('update', $this->deliveryAddress);
        }

        $this->deliveryAddress->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', DeliveryAddress::class);

        DeliveryAddress::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetDeliveryAddressData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->customer->deliveryAddresses as $deliveryAddress) {
            array_push($this->selected, $deliveryAddress->id);
        }
    }

    public function render()
    {
        return view('livewire.customer-delivery-addresses', [
            'deliveryAddresses' => $this->customer
                ->deliveryAddresses()
                ->paginate(20),
        ]);
    }
}
