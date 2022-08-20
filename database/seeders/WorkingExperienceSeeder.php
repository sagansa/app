<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkingExperience;

class WorkingExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkingExperience::factory()
            ->count(5)
            ->create();
    }
}
