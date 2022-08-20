<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionFrom extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['purchase_order_product_id', 'production_id'];

    protected $searchableFields = ['*'];

    protected $table = 'production_froms';

    public function production()
    {
        return $this->belongsTo(Production::class);
    }

    public function purchaseOrderProduct()
    {
        return $this->belongsTo(PurchaseOrderProduct::class);
    }
}
