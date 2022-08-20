<?php

namespace Database\Seeders;

use App\Models\UserCashless;
use Illuminate\Database\Seeder;

class UserCashlessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserCashless::factory()
            ->count(5)
            ->create();
    }
}
