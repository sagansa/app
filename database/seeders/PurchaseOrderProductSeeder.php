<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrderProduct;

class PurchaseOrderProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PurchaseOrderProduct::factory()
            ->count(5)
            ->create();
    }
}
