<?php

namespace Database\Seeders;

use App\Models\ShiftStore;
use Illuminate\Database\Seeder;

class ShiftStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShiftStore::factory()
            ->count(5)
            ->create();
    }
}
