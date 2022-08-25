<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClosingCourier extends Model
{
    use HasValid;
    use HasFactory;
    use Searchable;

    const STATUS_BELUM_DIPERIKSA = '1';
    const STATUS_VALID = '2';
    const STATUS_PERBAIKI = '3';

    const STATUSES = [
        '1' => 'belum diperiksa',
        '2' => 'valid',
        '3' => 'diperbaiki',
        // '4' => 'periksa ulang',
    ];

    protected $fillable = [
        'bank_id',
        'total_cash_to_transfer',
        'image',
        'status',
        'notes',
        'created_by_id',
        'approved_by_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'closing_couriers';

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function closingStores()
    {
        return $this->belongsToMany(ClosingStore::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
