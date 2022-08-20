<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\PermitEmployee;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermitEmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PermitEmployee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reason' => $this->faker->numberBetween(1, 7),
            'from_date' => $this->faker->date,
            'until_date' => $this->faker->date,
            'status' => $this->faker->numberBetween(1, 2),
            'notes' => $this->faker->text,
            'created_by_id' => \App\Models\User::factory(),
            'approved_by_id' => \App\Models\User::factory(),
        ];
    }
}
