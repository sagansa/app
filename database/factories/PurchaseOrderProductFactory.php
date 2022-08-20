<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\PurchaseOrderProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseOrderProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseOrderProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity_product' => $this->faker->randomNumber,
            'quantity_invoice' => $this->faker->randomNumber,
            'subtotal_invoice' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 3),
            'product_id' => \App\Models\Product::factory(),
            'purchase_order_id' => \App\Models\PurchaseOrder::factory(),
            'unit_id' => \App\Models\Unit::factory(),
        ];
    }
}
