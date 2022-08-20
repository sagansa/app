<?php

namespace App\Models;

use App\Http\Livewire\DataTables\HasActive;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasActive;
    use HasFactory;
    use Searchable;

    const STATUSES = [
        '1' => 'active',
        '2' => 'inactive',
    ];

    protected $fillable = [
        'image',
        'no_register',
        'type',
        'store_id',
        'status',
        'user_id',
        'notes',
    ];

    protected $searchableFields = ['*'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicleTaxes()
    {
        return $this->hasMany(VehicleTax::class);
    }

    public function vehicleCertificate()
    {
        return $this->hasOne(VehicleCertificate::class);
    }

    public function fuelServices()
    {
        return $this->hasMany(FuelService::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
