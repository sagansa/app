<?php

namespace Database\Seeders;

use App\Models\Regency;
use Illuminate\Database\Seeder;

class RegencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Regency::factory()
            ->count(5)
            ->create();
    }
}
