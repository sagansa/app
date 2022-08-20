<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\MovementAssetResult;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovementAssetResultFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MovementAssetResult::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'status' => $this->faker->numberBetween(0, 127),
            'notes' => $this->faker->text,
            'store_id' => \App\Models\Store::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
