<?php

namespace Database\Seeders;

use App\Models\RequestStock;
use Illuminate\Database\Seeder;

class RequestStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RequestStock::factory()
            ->count(5)
            ->create();
    }
}
