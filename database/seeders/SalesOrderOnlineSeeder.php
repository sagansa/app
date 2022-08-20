<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesOrderOnline;

class SalesOrderOnlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SalesOrderOnline::factory()
            ->count(5)
            ->create();
    }
}
