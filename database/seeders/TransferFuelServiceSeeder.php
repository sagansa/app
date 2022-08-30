<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransferFuelService;

class TransferFuelServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransferFuelService::factory()
            ->count(5)
            ->create();
    }
}
