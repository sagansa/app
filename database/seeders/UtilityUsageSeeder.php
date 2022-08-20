<?php

namespace Database\Seeders;

use App\Models\UtilityUsage;
use Illuminate\Database\Seeder;

class UtilityUsageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UtilityUsage::factory()
            ->count(5)
            ->create();
    }
}
