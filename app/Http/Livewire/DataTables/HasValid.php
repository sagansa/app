<?php

namespace App\Http\Livewire\DataTables;

trait HasValid
{
    public function getStatusBadgeAttribute()
    {
    	$badges = [
    		'1' => 'bg-yellow-100 text-yellow-800',
    		'2' => 'bg-green-100 text-green-800',
            '3' => 'bg-red-100 text-red-800',
            '4' => 'bg-gray-100 text-gray-800',
    	];

    	return $badges[$this->status];
    }

    public function getStatusNameAttribute()
    {
        $names = [
        '1' => 'belum diperiksa',
        '2' => 'valid',
        '3' => 'perbaiki',
        '4' => 'periksa ulang',
        ];

        return $names[$this->status];
    }

    public function getPermitBadgeAttribute()
    {
    	$badges = [
    		'1' => 'bg-yellow-100 text-yellow-800',
    		'2' => 'bg-green-100 text-green-800',
            '3' => 'bg-red-100 text-red-800',
            '4' => 'bg-gray-100 text-gray-800',
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

    public function getPaymentStatusBadgeAttribute()
    {
    	$badges = [
    		'1' => 'bg-yellow-100 text-yellow-800',
    		'2' => 'bg-green-100 text-green-800',
            '3' =>'bg-red-100 text-red-800',
    	];

    	return $badges[$this->payment_status];
    }

    public function getPaymentStatusNameAttribute()
    {
        $names = [
        '1' => 'belum dibayar',
        '2' => 'sudah dibayar',
        '3' => 'tidak valid'
        ];

        return $names[$this->payment_status];
    }

    public function getOrderStatusBadgeAttribute()
    {
    	$badges = [
    		'1' => 'bg-yellow-100 text-yellow-800',
    		'2' => 'bg-green-100 text-green-800',
            '3' =>'bg-red-100 text-red-800',
    	];

    	return $badges[$this->order_status];
    }

    public function getOrderStatusNameAttribute()
    {
        $names = [
        '1' => 'belum diterima',
        '2' => 'sudah diterima',
        '3' => 'dikembalikan'
        ];

        return $names[$this->order_status];
    }

    public function getDeliveryStatusBadgeAttribute()
    {
    	$badges = [
    		'1' => 'bg-yellow-100 text-yellow-800',
    		'2' => 'bg-green-100 text-green-800',
            '3' => 'bg-red-100 text-red-800',
            '4' => 'bg-gray-100 text-gray-800',
    	];

    	return $badges[$this->delivery_status];
    }

    public function getDeliveryStatusNameAttribute()
    {
        $names = [
        '1' => 'belum dikirim',
        '2' => 'valid',
        '3' => 'sudah dikirim',
        '4' => 'perbaiki',
        ];

        return $names[$this->delivery_status];
    }


}
