<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MovementAsset extends Model
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
        'image',
        'qr_code',
        'product_id',
        'good_cond_qty',
        'bad_cond_qty',
        'store_asset_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'movement_assets';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function movementAssetAudits()
    {
        return $this->hasMany(MovementAssetAudit::class);
    }

    public function storeAsset()
    {
        return $this->belongsTo(StoreAsset::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
