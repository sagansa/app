<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrderProduct extends Model
{
    use HasFactory;
    use Searchable;

    const STATUS_PROCESS = '1';
    const STATUS_DONE = '2';
    const STATUS_NO_NEED = '3';

    const STATUSES = [
        '1' => 'process',
        '2' => 'done',
        '3' => 'no need',
    ];

    protected $fillable = [
        'product_id',
        'purchase_order_id',
        'quantity_product',
        'quantity_invoice',
        'unit_id',
        'subtotal_invoice',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'purchase_order_products';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function productionFroms()
    {
        return $this->hasMany(ProductionFrom::class);
    }

    public function getProductNameAttribute()
    {
        return $this->purchaseOrder->store->nickname . ' - ' . $this->purchaseOrder->date->toFormattedDate() . ' - ' . $this->product->name . ' = ' . $this->quantity_product . ' ' . $this->product->unit->unit;
    }
}
