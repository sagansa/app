<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContractLocation;

class ContractLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContractLocation::factory()
            ->count(5)
            ->create();
    }
}
