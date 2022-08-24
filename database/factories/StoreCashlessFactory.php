<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\StoreCashless;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreCashlessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StoreCashless::class;

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
