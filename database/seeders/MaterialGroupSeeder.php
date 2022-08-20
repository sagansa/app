<?php

namespace Database\Seeders;

use App\Models\MaterialGroup;
use Illuminate\Database\Seeder;

class MaterialGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MaterialGroup::factory()
            ->count(5)
            ->create();
    }
}
