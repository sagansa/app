<?php

namespace Database\Seeders;

use App\Models\StoreAsset;
use Illuminate\Database\Seeder;

class StoreAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StoreAsset::factory()
            ->count(5)
            ->create();
    }
}
