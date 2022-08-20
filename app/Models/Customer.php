<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
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

    protected $fillable = ['name', 'no_telp', 'status', 'user_id'];

    protected $searchableFields = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salesOrderEmployees()
    {
        return $this->hasMany(SalesOrderEmployee::class);
    }

    public function salesOrderOnlines()
    {
        return $this->hasMany(SalesOrderOnline::class);
    }

    public function deliveryAddresses()
    {
        return $this->hasMany(DeliveryAddress::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
