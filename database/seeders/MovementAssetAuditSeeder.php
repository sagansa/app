<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MovementAssetAudit;

class MovementAssetAuditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MovementAssetAudit::factory()
            ->count(5)
            ->create();
    }
}
