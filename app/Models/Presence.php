<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presence extends Model
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
        'closing_store_id',
        'amount',
        'payment_type_id',
        'status',
        'image_in',
        'image_out',
        'lat_long_in',
        'lat_long_out',
        'created_by_id',
        'approved_by_id',
    ];

    protected $searchableFields = ['*'];

    public function monthlySalary()
    {
        return $this->hasOne(MonthlySalary::class);
    }

    public function closingStore()
    {
        return $this->belongsTo(ClosingStore::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function transferDailySalaries()
    {
        return $this->belongsToMany(TransferDailySalary::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }

    public function getPresenceNameAttribute()
    {
        return $this->created_by->name . ' - ' . $this->closingStore->store->nickname . ' - ' . $this->closingStore->date->toFormattedDate();
    }
}
