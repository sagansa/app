<?php

namespace App\Http\Livewire\DataTables;

trait HasActive
{
    public function getStatusBadgeAttribute()
    {
    	$badges = [
    		'1' => 'bg-green-200 text-green-900',
            '2' => 'bg-red-200 text-red-900',
    	];

    	return $badges[$this->status];
    }

    public function getStatusNameAttribute()
    {
        $names = [
        '1' => 'active',
        '2' => 'inactive',
        ];

        return $names[$this->status];
    }

    public function getRequestBadgeAttribute()
    {
    	$badges = [
    		'1' => 'bg-green-200 text-green-900',
            '2' => 'bg-red-200 text-red-900',
    	];

    	return $badges[$this->request];
    }

    public function getRequestNameAttribute()
    {
        $names = [
        '1' => 'active',
        '2' => 'inactive',
        ];

        return $names[$this->request];
    }

    public function getremainingBadgeAttribute()
    {
    	$badges = [
    		'1' => 'bg-green-200 text-green-900',
            '2' => 'bg-red-200 text-red-900',
    	];

    	return $badges[$this->remaining];
    }

    public function getRemainingNameAttribute()
    {
        $names = [
        '1' => 'active',
        '2' => 'inactive',
        ];

        return $names[$this->remaining];
    }
    
}
