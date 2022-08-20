<?php

namespace Database\Seeders;

use App\Models\FuelService;
use Illuminate\Database\Seeder;

class FuelServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FuelService::factory()
            ->count(5)
            ->create();
    }
}
