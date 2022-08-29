<?php

namespace Database\Factories;

use App\Models\UtilityBill;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UtilityBillFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UtilityBill::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'amount' => $this->faker->text(255),
            'initial_indicator' => $this->faker->randomNumber(2),
            'last_indicator' => $this->faker->randomNumber(2),
            'utility_id' => \App\Models\Utility::factory(),
        ];
    }
}
