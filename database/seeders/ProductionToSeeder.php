<?php

namespace Database\Seeders;

use App\Models\ProductionTo;
use Illuminate\Database\Seeder;

class ProductionToSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductionTo::factory()
            ->count(5)
            ->create();
    }
}
