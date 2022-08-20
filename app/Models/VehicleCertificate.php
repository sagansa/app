<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleCertificate extends Model
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

    protected $fillable = [
        'vehicle_id',
        'BPKB',
        'STNK',
        'name',
        'brand',
        'type',
        'category',
        'model',
        'manufacture_year',
        'cylinder_capacity',
        'vehilce_identity_no',
        'engine_no',
        'color',
        'type_fuel',
        'lisence_plate_color',
        'registration_year',
        'bpkb_no',
        'location_code',
        'registration_queue_no',
        'notes',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'vehicle_certificates';

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
