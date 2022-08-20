<?php

namespace Database\Seeders;

use App\Models\ClosingStore;
use Illuminate\Database\Seeder;

class ClosingStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClosingStore::factory()
            ->count(5)
            ->create();
    }
}
