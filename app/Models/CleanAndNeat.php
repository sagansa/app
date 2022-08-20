<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CleanAndNeat extends Model
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
        'left_hand',
        'right_hand',
        'status',
        'notes',
        'created_by_id',
        'updated_by_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'clean_and_neats';

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function delete_left_hand()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }

    public function delete_right_hand()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
