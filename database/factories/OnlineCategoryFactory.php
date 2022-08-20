<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\OnlineCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class OnlineCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OnlineCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(50),
            'status' => $this->faker->numberBetween(1, 2),
        ];
    }
}
