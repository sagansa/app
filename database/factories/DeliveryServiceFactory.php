<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DeliveryService;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DeliveryService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'status' => $this->faker->numberBetween(1, 2),
        ];
    }
}
