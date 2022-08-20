<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SelfConsumption;

class SelfConsumptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SelfConsumption::factory()
            ->count(5)
            ->create();
    }
}
