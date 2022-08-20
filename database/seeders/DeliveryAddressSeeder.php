<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryAddress;

class DeliveryAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DeliveryAddress::factory()
            ->count(5)
            ->create();
    }
}
