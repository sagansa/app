<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractEmployee extends Model
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
        'file',
        'from_date',
        'until_date',
        'nominal_guarantee',
        'guarantee',
        'employee_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'contract_employees';

    protected $casts = [
        'from_date' => 'date',
        'until_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
