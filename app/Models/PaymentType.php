<?php

namespace App\Models;

use App\Http\Livewire\DataTables\HasActive;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentType extends Model
{
    use HasActive;
    use HasFactory;
    use Searchable;

    const STATUSES = [
        '1' => 'active',
        '2' => 'inactive',
    ];

    protected $fillable = ['name', 'status'];

    protected $searchableFields = ['*'];

    protected $table = 'payment_types';

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
