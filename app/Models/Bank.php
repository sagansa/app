<?php

namespace App\Models;

use App\Http\Livewire\DataTables\HasActive;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank extends Model
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

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function closingCouriers()
    {
        return $this->hasMany(ClosingCourier::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
