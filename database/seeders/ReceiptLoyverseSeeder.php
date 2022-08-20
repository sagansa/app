<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReceiptLoyverse;

class ReceiptLoyverseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReceiptLoyverse::factory()
            ->count(5)
            ->create();
    }
}
