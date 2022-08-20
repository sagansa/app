<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReceiptLoyverse extends Model
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
        'date',
        'receipt_number',
        'receipt_type',
        'gross_sales',
        'discounts',
        'net_sales',
        'taxes',
        'total_collected',
        'cost_of_goods',
        'gross_profit',
        'payment_type',
        'description',
        'dining_option',
        'pos',
        'store',
        'cashier_name',
        'customer_name',
        'customer_contacts',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'receipt_loyverses';

    protected $casts = [
        'date' => 'date',
    ];

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
