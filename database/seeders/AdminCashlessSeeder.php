<?php

namespace Database\Seeders;

use App\Models\AdminCashless;
use Illuminate\Database\Seeder;

class AdminCashlessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminCashless::factory()
            ->count(5)
            ->create();
    }
}
