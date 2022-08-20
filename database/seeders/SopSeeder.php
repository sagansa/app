<?php

namespace Database\Seeders;

use App\Models\Sop;
use Illuminate\Database\Seeder;

class SopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sop::factory()
            ->count(5)
            ->create();
    }
}
