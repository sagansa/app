<?php

namespace Database\Seeders;

use App\Models\Saving;
use Illuminate\Database\Seeder;

class SavingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Saving::factory()
            ->count(5)
            ->create();
    }
}
