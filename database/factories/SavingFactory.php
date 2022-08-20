<?php

namespace Database\Factories;

use App\Models\Saving;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SavingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Saving::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'debet_credit' => $this->faker->numberBetween(0, 127),
            'nominal' => $this->faker->randomNumber,
            'employee_id' => \App\Models\Employee::factory(),
        ];
    }
}
