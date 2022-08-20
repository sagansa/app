<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractLocation extends Model
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
        'store_id',
        'file',
        'address',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'codepos',
        'gps_location',
        'from_date',
        'until_date',
        'contact_person',
        'no_contact_person',
        'nominal_contract_per_year',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'contract_locations';

    protected $casts = [
        'from_date' => 'date',
        'until_date' => 'date',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
