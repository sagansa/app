<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cashless extends Model
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
        'user_cashless_id',
        'bruto_apl',
        'netto_apl',
        'bruto_real',
        'netto_real',
        'image_canceled',
        'canceled',
        'closing_store_id',
    ];

    protected $searchableFields = ['*'];

    public function userCashless()
    {
        return $this->belongsTo(UserCashless::class);
    }

    public function closingStore()
    {
        return $this->belongsTo(ClosingStore::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
