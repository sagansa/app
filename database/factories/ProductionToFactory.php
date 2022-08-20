<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ProductionTo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionToFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductionTo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => $this->faker->randomNumber,
            'product_id' => \App\Models\Product::factory(),
            'production_id' => \App\Models\Production::factory(),
        ];
    }
}
