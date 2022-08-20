<?php

namespace Database\Seeders;

use App\Models\TransferStock;
use Illuminate\Database\Seeder;

class TransferStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransferStock::factory()
            ->count(5)
            ->create();
    }
}
