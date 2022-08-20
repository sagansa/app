<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminCashless extends Model
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
        'username',
        'email',
        'no_telp',
        'password',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'admin_cashlesses';

    protected $hidden = ['password'];

    public function userCashlesses()
    {
        return $this->hasMany(UserCashless::class);
    }

    public function cashlessProvider()
    {
        return $this->belongsTo(CashlessProvider::class);
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

    public function getAdminNameAttribute()
    {
        return $this->cashlessProvider->name . ' - ' . $this->email;
    }
}
