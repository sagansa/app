<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\RestaurantCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RestaurantCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(50),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
