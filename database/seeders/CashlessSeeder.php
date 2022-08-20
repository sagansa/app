<?php

namespace Database\Seeders;

use App\Models\Cashless;
use Illuminate\Database\Seeder;

class CashlessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cashless::factory()
            ->count(5)
            ->create();
    }
}
