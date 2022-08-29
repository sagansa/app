<?php

namespace App\Models;

use App\Http\Livewire\DataTables\HasActive;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasActive;
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    // use Sluggable;

    const STATUSES = [
        '1' => 'active',
        '2' => 'inactive',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'barcode',
        'description',
        'image',
        'request',
        'remaining',
        'unit_id',
        'material_group_id',
        'franchise_group_id',
        'payment_type_id',
        'online_category_id',
        'product_group_id',
        'restaurant_category_id',
        'user_id',
    ];

    protected $searchableFields = ['*'];

    public function movementAssets()
    {
        return $this->hasMany(MovementAsset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function materialGroup()
    {
        return $this->belongsTo(MaterialGroup::class);
    }

    public function franchiseGroup()
    {
        return $this->belongsTo(FranchiseGroup::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function onlineCategory()
    {
        return $this->belongsTo(OnlineCategory::class);
    }

    public function productGroup()
    {
        return $this->belongsTo(ProductGroup::class);
    }

    public function purchaseOrderProducts()
    {
        return $this->hasMany(PurchaseOrderProduct::class);
    }

    public function restaurantCategory()
    {
        return $this->belongsTo(RestaurantCategory::class);
    }

    public function productionsTo()
    {
        return $this->hasMany(Production::class);
    }

    public function remainingStocks()
    {
        return $this->belongsToMany(RemainingStock::class);
    }

    public function transferStocks()
    {
        return $this->belongsToMany(TransferStock::class);
    }

    public function salesOrderEmployees()
    {
        return $this->belongsToMany(SalesOrderEmployee::class);
    }

    public function salesOrderOnlines()
    {
        return $this->belongsToMany(SalesOrderOnline::class);
    }

    public function requestStocks()
    {
        return $this->belongsToMany(RequestStock::class);
    }

    public function selfConsumptions()
    {
        return $this->belongsToMany(SelfConsumption::class);
    }

    public function outInProducts()
    {
        return $this->belongsToMany(OutInProduct::class);
    }

    public function productionsFrom()
    {
        return $this->belongsToMany(Production::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }

    public function getProductNameAttribute()
    {
        return $this->name . ' - ' . $this->unit->unit;
    }
}
