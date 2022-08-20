<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\CleanAndNeat;
use Illuminate\Database\Eloquent\Factories\Factory;

class CleanAndNeatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CleanAndNeat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'left_hand' => $this->faker->text(255),
            'right_hand' => $this->faker->text(255),
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'created_by_id' => \App\Models\User::factory(),
            'approved_by_id' => \App\Models\User::factory(),
        ];
    }
}
