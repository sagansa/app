<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ProductionFrom;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionFromFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductionFrom::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'production_id' => \App\Models\Production::factory(),
            'purchase_order_product_id' => \App\Models\PurchaseOrderProduct::factory(),
        ];
    }
}
