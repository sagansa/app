<?php

namespace Database\Seeders;

use App\Models\Hygiene;
use Illuminate\Database\Seeder;

class HygieneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hygiene::factory()
            ->count(5)
            ->create();
    }
}
