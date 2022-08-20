<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'no_register' => $this->faker->text(15),
            'type' => $this->faker->numberBetween(1, 3),
            'status' => $this->faker->numberBetween(1, 2),
            'notes' => $this->faker->text,
            'store_id' => \App\Models\Store::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
