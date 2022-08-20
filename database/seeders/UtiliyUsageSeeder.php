<?php

namespace Database\Seeders;

use App\Models\UtiliyUsage;
use Illuminate\Database\Seeder;

class UtiliyUsageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UtiliyUsage::factory()
            ->count(5)
            ->create();
    }
}
