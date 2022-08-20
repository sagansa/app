<?php

namespace Database\Seeders;

use App\Models\MovementAsset;
use Illuminate\Database\Seeder;

class MovementAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MovementAsset::factory()
            ->count(5)
            ->create();
    }
}
