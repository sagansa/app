<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReceiptByItemLoyverse;

class ReceiptByItemLoyverseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReceiptByItemLoyverse::factory()
            ->count(5)
            ->create();
    }
}
