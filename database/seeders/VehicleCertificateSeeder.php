<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleCertificate;

class VehicleCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleCertificate::factory()
            ->count(5)
            ->create();
    }
}
