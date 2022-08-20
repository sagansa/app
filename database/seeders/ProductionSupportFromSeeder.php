<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductionSupportFrom;

class ProductionSupportFromSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductionSupportFrom::factory()
            ->count(5)
            ->create();
    }
}
