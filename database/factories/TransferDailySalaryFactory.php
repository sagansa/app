<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\TransferDailySalary;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransferDailySalaryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TransferDailySalary::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'image' => $this->faker->text(255),
            'amount' => $this->faker->randomNumber,
        ];
    }
}
