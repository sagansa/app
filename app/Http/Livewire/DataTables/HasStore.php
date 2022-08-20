<?php

namespace App\Http\Livewire\DataTables;

trait HasStore
{
    public function getStatusBadgeAttribute()
    {
    	$badges = [
    		'1' => 'bg-green-200 text-green-800',
    		'2' => 'bg-green-200 text-green-800',
            '3' => 'bg-green-200 text-green-800',
            '4' => 'bg-red-200 text-red-800',
    	];

    	return $badges[$this->status];
    }

    public function getStatusNameAttribute()
    {
        $names = [
        '1' => 'warung',
        '2' => 'gudang',
        '3' => 'warung & gudang',
        '4' => 'tidak aktif',
        ];

        return $names[$this->status];
    }

    public function getPermitBadgeAttribute()
    {
    	$badges = [
    		'1' => 'bg-yellow-200 text-yellow-800',
    		'2' => 'bg-green-200 text-green-800',
            '3' => 'bg-red-200 text-red-800',
            '4' => 'bg-gray-200 text-gray-800',
    	];

    	return $badges[$this->permit];
    }

    public function getPermitNameAttribute()
    {
        $names = [
        '1' => 'belum disetujui',
        '2' => 'disetujui',
        '3' => 'perbaiki',
        '4' => 'pengajuan ulang',
        ];

        return $names[$this->permit];
    }


}
