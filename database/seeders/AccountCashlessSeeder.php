<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccountCashless;

class AccountCashlessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountCashless::factory()
            ->count(5)
            ->create();
    }
}
