<?php

namespace App\Http\Livewire\Suppliers;

use App\Models\Bank;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Supplier;
use App\Models\Village;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CreateSupplierForm extends Component
{
    public $bank_account_name;
    public $name;
    public $bank_name;
    public $bank_id;
    public $address;
    public $no_telp;
    public $codepos;
    public $status;

    public $provinces;
    public $selectedProvince = null;

    public $regencies;
    public $selectedRegency = null;

    public $villages;
    public $selectedVillage = null;

    public $districts;
    public $selectedDistrict = null;

    public function mount()
    {
        $this->provinces = Province::all();
        $this->regencies = collect();
        $this->villages = collect();
        $this->districts = collect();
    }

    public function updatedSelectedProvince($value)
    {
        $this->regencies = Regency::where('country_id', $value)->get();
        $this->selectedRegency = null;
    }

    public function updatedSelectedRegency($value)
    {
        $this->villages = Village::where('regency_id', $value)->get();
        $this->selectedVillage = null;
    }

    public function updatedSelectedVillage($value)
    {
        $this->districts = District::where('village_id', $value)->get();
        $this->selectedDistrict = null;
    }

    public function create()
    {
        $this->validate([

        ]);

        Supplier::create([
            'name' => $this->name,
            'no_telp' => $this->no_telp,
            'address' => $this->address,
            'district_id' => $this->selectedDistrict,
        ]);

        $this->name = '';
        $this->selectedProvince = null;
        $this->selectedRegency = null;
        $this->selectedDistrict = null;
        $this->selectedVillage = null;

        $this->regencies = collect();
        $this->districts = collect();
        $this->villages = collect();

        return redirect()->route('suppliers.index');
    }

    public function render()
    {
        $banks = Bank::all();

        return view('livewire.suppliers.create-supplier-form', [
            'banks' => $banks,
            'suppliers' => supplier::with('bank')->latest()->take(5)->get()
        ]);
    }
}
