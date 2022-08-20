<?php

namespace Database\Seeders;

use App\Models\HygieneOfRoom;
use Illuminate\Database\Seeder;

class HygieneOfRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HygieneOfRoom::factory()
            ->count(5)
            ->create();
    }
}
