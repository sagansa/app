<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransferDailySalary;

class TransferDailySalarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransferDailySalary::factory()
            ->count(5)
            ->create();
    }
}
