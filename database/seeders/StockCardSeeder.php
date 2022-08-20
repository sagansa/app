<?php

namespace Database\Seeders;

use App\Models\StockCard;
use Illuminate\Database\Seeder;

class StockCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StockCard::factory()
            ->count(5)
            ->create();
    }
}
