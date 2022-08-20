<?php

namespace Database\Seeders;

use App\Models\ProductionFrom;
use Illuminate\Database\Seeder;

class ProductionFromSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductionFrom::factory()
            ->count(5)
            ->create();
    }
}
