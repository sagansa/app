<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasValid;
    use HasFactory;
    use Searchable;

    const STATUSES = [
        '1' => 'belum diperiksa',
        '2' => 'valid',
        '3' => 'diperbaiki',
        '4' => 'periksa ulang',
    ];

    protected $fillable = ['name'];

    protected $searchableFields = ['*'];

    public function regencies()
    {
        return $this->hasMany(Regency::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function contractLocations()
    {
        return $this->hasMany(ContractLocation::class);
    }

    public function deliveryAddresses()
    {
        return $this->hasMany(DeliveryAddress::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
