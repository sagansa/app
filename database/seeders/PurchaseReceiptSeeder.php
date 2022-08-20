<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseReceipt;

class PurchaseReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PurchaseReceipt::factory()
            ->count(5)
            ->create();
    }
}
