<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
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
        'name',
        'nickname',
        'no_telp',
        'email',
        'user_id',
        'status',
    ];

    protected $searchableFields = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contractLocations()
    {
        return $this->hasMany(ContractLocation::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function movementAssetResults()
    {
        return $this->hasMany(MovementAssetResult::class);
    }

    public function closingStores()
    {
        return $this->hasMany(ClosingStore::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function remainingStocks()
    {
        return $this->hasMany(RemainingStock::class);
    }

    public function requestStocks()
    {
        return $this->hasMany(RequestStock::class);
    }

    public function productions()
    {
        return $this->hasMany(Production::class);
    }

    public function salesOrderEmployees()
    {
        return $this->hasMany(SalesOrderEmployee::class);
    }

    public function salesOrderOnlines()
    {
        return $this->hasMany(SalesOrderOnline::class);
    }

    public function fromTransferStocks()
    {
        return $this->hasMany(TransferStock::class, 'from_store_id');
    }

    public function toTransferStocks()
    {
        return $this->hasMany(TransferStock::class, 'to_store_id');
    }

    public function hygienes()
    {
        return $this->hasMany(Hygiene::class);
    }

    public function selfConsumptions()
    {
        return $this->hasMany(SelfConsumption::class);
    }

    public function stockCards()
    {
        return $this->hasMany(StockCard::class);
    }

    public function utilities()
    {
        return $this->hasMany(Utility::class);
    }

    public function storeAssets()
    {
        return $this->hasMany(StoreAsset::class);
    }

    public function accountCashlesses()
    {
        return $this->hasMany(AccountCashless::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
