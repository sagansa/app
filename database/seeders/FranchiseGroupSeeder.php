<?php

namespace Database\Seeders;

use App\Models\FranchiseGroup;
use Illuminate\Database\Seeder;

class FranchiseGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FranchiseGroup::factory()
            ->count(5)
            ->create();
    }
}
