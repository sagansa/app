<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesOrderEmployee;

class SalesOrderEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SalesOrderEmployee::factory()
            ->count(5)
            ->create();
    }
}
