<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ClosingCourier;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClosingCourierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClosingCourier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'total_cash_to_transfer' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'bank_id' => \App\Models\Bank::factory(),
            'created_by_id' => \App\Models\User::factory(),
            'approved_by_id' => \App\Models\User::factory(),
        ];
    }
}
