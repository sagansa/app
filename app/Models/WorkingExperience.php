<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkingExperience extends Model
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
        'employee_id',
        'place',
        'position',
        'salary_per_month',
        'previous_boss_name',
        'previous_boss_no',
        'from_date',
        'until_date',
        'reason',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'working_experiences';

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
