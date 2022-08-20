<?php

namespace Database\Seeders;

use App\Models\VehicleTax;
use Illuminate\Database\Seeder;

class VehicleTaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleTax::factory()
            ->count(5)
            ->create();
    }
}
