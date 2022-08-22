<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
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
        'name',
        'no_telp',
        'address',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'codepos',
        'bank_id',
        'bank_account_name',
        'bank_account_no',
        'status',
        'user_id',
    ];

    protected $searchableFields = ['*'];

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

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSupplierNameAttribute()
    {
        if ($this->bank_account_name != null) {

            return $this->name . ' - ' . $this->bank->name . ' -' . $this->bank_account_name . ' - ' . $this->bank_account_no;

        } else {

            return $this->name;

        }
    }
}
