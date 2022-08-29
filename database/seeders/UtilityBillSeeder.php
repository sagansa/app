<?php

namespace Database\Seeders;

use App\Models\UtilityBill;
use Illuminate\Database\Seeder;

class UtilityBillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UtilityBill::factory()
            ->count(5)
            ->create();
    }
}
