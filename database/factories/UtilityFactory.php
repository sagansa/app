<?php

namespace Database\Factories;

use App\Models\Utility;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UtilityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Utility::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->randomNumber(),
            'name' => $this->faker->name,
            'category' => $this->faker->numberBetween(1, 3),
            'pre_post' => $this->faker->numberBetween(1, 2),
            'status' => $this->faker->numberBetween(1, 2),
            'unit_id' => \App\Models\Unit::factory(),
            'utility_provider_id' => \App\Models\UtilityProvider::factory(),
            'store_id' => \App\Models\Store::factory(),
        ];
    }
}
