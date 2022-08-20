<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\UtilityProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class UtilityProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UtilityProvider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(20),
            'category' => $this->faker->numberBetween(1, 3),
        ];
    }
}
