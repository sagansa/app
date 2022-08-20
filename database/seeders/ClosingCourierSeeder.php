<?php

namespace Database\Seeders;

use App\Models\ClosingCourier;
use Illuminate\Database\Seeder;

class ClosingCourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClosingCourier::factory()
            ->count(5)
            ->create();
    }
}
