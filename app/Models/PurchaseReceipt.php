<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseReceipt extends Model
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

    protected $fillable = ['image', 'nominal_transfer', 'user_id'];

    protected $searchableFields = ['*'];

    protected $table = 'purchase_receipts';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchaseOrders()
    {
        return $this->belongsToMany(PurchaseOrder::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
