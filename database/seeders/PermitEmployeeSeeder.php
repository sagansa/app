<?php

namespace Database\Seeders;

use App\Models\PermitEmployee;
use Illuminate\Database\Seeder;

class PermitEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermitEmployee::factory()
            ->count(5)
            ->create();
    }
}
