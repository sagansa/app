<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferStock extends Model
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
        'image',
        'from_store_id',
        'to_store_id',
        'status',
        'notes',
        'approved_by_id',
        'received_by_id',
        'sent_by_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'transfer_stocks';

    protected $casts = [
        'date' => 'date',
    ];

    public function from_store()
    {
        return $this->belongsTo(Store::class, 'from_store_id');
    }

    public function to_store()
    {
        return $this->belongsTo(Store::class, 'to_store_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function received_by()
    {
        return $this->belongsTo(User::class, 'received_by_id');
    }

    public function sent_by()
    {
        return $this->belongsTo(User::class, 'sent_by_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
