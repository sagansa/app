<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\UtilityUsage;
use Illuminate\Database\Eloquent\Factories\Factory;

class UtilityUsageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UtilityUsage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'result' => $this->faker->randomNumber(2),
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'created_by_id' => \App\Models\User::factory(),
            'approved_by_id' => \App\Models\User::factory(),
            'utility_id' => \App\Models\Utility::factory(),
        ];
    }
}
