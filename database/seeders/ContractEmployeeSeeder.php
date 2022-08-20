<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContractEmployee;

class ContractEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContractEmployee::factory()
            ->count(5)
            ->create();
    }
}
