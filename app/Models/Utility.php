<?php

namespace App\Models;

use App\Http\Livewire\DataTables\HasActive;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Utility extends Model
{
    use HasActive;
    use HasFactory;
    use Searchable;

    const STATUSES = [
        '1' => 'active',
        '2' => 'inactive',
    ];

    protected $fillable = [
        'number',
        'name',
        'store_id',
        'category',
        'unit_id',
        'utility_provider_id',
        'pre_post',
        'status',
    ];

    protected $searchableFields = ['*'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function utilityProvider()
    {
        return $this->belongsTo(UtilityProvider::class);
    }

    public function utilityUsages()
    {
        return $this->hasMany(UtilityUsage::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }

    public function getUtilityNameAttribute()
    {
        return $this->store->nickname . ' - ' . $this->number . ' - ' . $this->utilityProvider->name . ' - ' . $this->unit->unit;
    }
}
