<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MovementAssetAudit extends Model
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
        'movement_asset_id',
        'good_cond_qty',
        'bad_cond_qty',
        'movement_asset_result_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'movement_asset_audits';

    public function movementAsset()
    {
        return $this->belongsTo(MovementAsset::class);
    }

    public function movementAssetResult()
    {
        return $this->belongsTo(MovementAssetResult::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
