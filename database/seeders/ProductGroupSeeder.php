<?php

namespace Database\Seeders;

use App\Models\ProductGroup;
use Illuminate\Database\Seeder;

class ProductGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductGroup::factory()
            ->count(5)
            ->create();
    }
}
