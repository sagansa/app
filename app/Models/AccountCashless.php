<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountCashless extends Model
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
        'cashless_provider_id',
        'store_id',
        'store_cashless_id',
        'email',
        'username',
        'password',
        'no_telp',
        'status',
        'notes',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'account_cashlesses';

    protected $hidden = ['password'];

    public function cashlessProvider()
    {
        return $this->belongsTo(CashlessProvider::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function storeCashless()
    {
        return $this->belongsTo(StoreCashless::class);
    }

    public function cashlesses()
    {
        return $this->hasMany(Cashless::class);
    }

    public function adminCashlesses()
    {
        return $this->belongsToMany(AdminCashless::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }

    public function getAccountCashlessNameAttribute()
    {
        return $this->cashlessProvider->name . ' - ' . $this->storeCashless->name . ' - ' . $this->store->nickname;
    }
}
