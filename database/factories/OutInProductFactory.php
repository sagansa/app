<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\OutInProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class OutInProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OutInProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'out_in' => $this->faker->numberBetween(1, 2),
            're' => $this->faker->text(50),
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'stock_card_id' => \App\Models\StockCard::factory(),
            'created_by_id' => \App\Models\User::factory(),
            'approved_by_id' => \App\Models\User::factory(),
            'delivery_service_id' => \App\Models\DeliveryService::factory(),
        ];
    }
}
