<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UtilityBill extends Model
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
        'utility_id',
        'image',
        'date',
        'amount',
        'initial_indicator',
        'last_indicator',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'utility_bills';

    protected $casts = [
        'date' => 'date',
    ];

    public function utility()
    {
        return $this->belongsTo(Utility::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
