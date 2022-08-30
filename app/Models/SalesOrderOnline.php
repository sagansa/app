<?php

namespace App\Models;

use App\Http\Livewire\DataTables\HasDeliveryStatus;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesOrderOnline extends Model
{
    use HasDeliveryStatus;
    use HasFactory;
    use Searchable;

    const STATUSES = [
        '1' => 'belum dikirim',
        '2' => 'valid',
        '3' => 'sudah dikirim',
        '4' => 'dikembalikan',
    ];

    protected $fillable = [
        'image',
        'store_id',
        'online_shop_provider_id',
        'delivery_service_id',
        'date',
        'customer_id',
        'delivery_address_id',
        'receipt_no',
        'status',
        'notes',
        'created_by_id',
        'approved_by_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'sales_order_onlines';

    protected $casts = [
        'date' => 'date',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function onlineShopProvider()
    {
        return $this->belongsTo(OnlineShopProvider::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function deliveryService()
    {
        return $this->belongsTo(DeliveryService::class);
    }

    public function deliveryAddress()
    {
        return $this->belongsTo(DeliveryAddress::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('price', 'quantity');
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
