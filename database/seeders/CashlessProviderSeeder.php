<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CashlessProvider;

class CashlessProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CashlessProvider::factory()
            ->count(5)
            ->create();
    }
}
