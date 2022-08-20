<?php

namespace Database\Seeders;

use App\Models\MonthlySalary;
use Illuminate\Database\Seeder;

class MonthlySalarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MonthlySalary::factory()
            ->count(5)
            ->create();
    }
}
