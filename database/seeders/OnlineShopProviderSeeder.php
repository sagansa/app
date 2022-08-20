<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OnlineShopProvider;

class OnlineShopProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OnlineShopProvider::factory()
            ->count(5)
            ->create();
    }
}
