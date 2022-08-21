<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCashless extends Model
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
        'admin_cashless_id',
        'store_id',
        'email',
        'username',
        'password',
        'no_telp',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'user_cashlesses';

    protected $hidden = ['password'];

    public function adminCashless()
    {
        return $this->belongsTo(AdminCashless::class);
    }

    public function cashlesses()
    {
        return $this->hasMany(Cashless::class);
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

    public function getUserCashlessNameAttribute()
    {
        return $this->adminCashless->cashlessProvider->name . ' - ' . $this->store->nickname . ' - ' . $this->email;
    }
}
