<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MovementAssetResult;

class MovementAssetResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MovementAssetResult::factory()
            ->count(5)
            ->create();
    }
}
