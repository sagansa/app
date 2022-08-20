<?php

namespace App\Models;

use App\Http\Livewire\DataTables\HasActive;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialGroup extends Model
{
    use HasActive;
    use HasFactory;
    use Searchable;

    const STATUSES = [
        '1' => 'active',
        '2' => 'inactive',
    ];

    protected $fillable = ['name', 'status', 'user_id'];

    protected $searchableFields = ['*'];

    protected $table = 'material_groups';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
