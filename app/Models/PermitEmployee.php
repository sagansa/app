<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermitEmployee extends Model
{
    use HasValid;
    use HasFactory;
    use Searchable;

    const STATUSES = [
        '1' => 'belum disetujui',
        '2' => 'disetujui',
        '3' => 'diperbaiki',
        '4' => 'pengajuan ulang',
    ];

    protected $fillable = [
        'reason',
        'from_date',
        'until_date',
        'status',
        'notes',
        'created_by_id',
        'approved_by_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'permit_employees';

    protected $casts = [
        'from_date' => 'date',
        'until_date' => 'date',
    ];

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

}
