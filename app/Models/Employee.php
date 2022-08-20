<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Livewire\DataTables\HasValid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasValid;
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    const STATUSES = [
        '1' => 'belum diperiksa',
        '2' => 'valid',
        '3' => 'diperbaiki',
        '4' => 'periksa ulang',
    ];

    protected $fillable = [
        'identity_no',
        'fullname',
        'nickname',
        'no_telp',
        'birth_place',
        'birth_date',
        'gender',
        'religion',
        'marital_status',
        'level_of_education',
        'major',
        'fathers_name',
        'mothers_name',
        'address',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'codepos',
        'gps_location',
        'parents_no_telp',
        'siblings_name',
        'siblings_no_telp',
        'bpjs',
        'driver_license',
        'bank_id',
        'bank_account_no',
        'accepted_work_date',
        'ttd',
        'notes',
        'image_identity_id',
        'image_selfie',
        'user_id',
        'employee_status_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'birth_date' => 'date',
        'bpjs' => 'boolean',
        'accepted_work_date' => 'date',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function savings()
    {
        return $this->hasMany(Saving::class);
    }

    public function contractEmployees()
    {
        return $this->hasMany(ContractEmployee::class);
    }

    public function workingExperiences()
    {
        return $this->hasMany(WorkingExperience::class);
    }

    public function employeeStatus()
    {
        return $this->belongsTo(EmployeeStatus::class);
    }

    public function delete_image()
    {
        if ($this->image && file_exists('storage/' . $this->image)) {
            unlink('storage/' . $this->image);
        }
    }
}
