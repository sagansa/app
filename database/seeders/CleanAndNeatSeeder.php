<?php

namespace Database\Seeders;

use App\Models\CleanAndNeat;
use Illuminate\Database\Seeder;

class CleanAndNeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CleanAndNeat::factory()
            ->count(5)
            ->create();
    }
}
