<?php

namespace App\Models;

use App\Http\Livewire\DataTables\HasActive;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreAsset extends Model
{
    use HasActive;
    use HasFactory;
    use Searchable;

    const STATUSES = [
        '1' => 'active',
        '2' => 'inactive',
    ];

    protected $fillable = ['store_id', 'status', 'notes'];

    protected $searchableFields = ['*'];

    protected $table = 'store_assets';

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function movementAssets()
    {
        return $this->hasMany(MovementAsset::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
