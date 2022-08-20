<?php

namespace Database\Seeders;

use App\Models\OutInProduct;
use Illuminate\Database\Seeder;

class OutInProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OutInProduct::factory()
            ->count(5)
            ->create();
    }
}
