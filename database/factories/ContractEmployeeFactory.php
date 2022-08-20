<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ContractEmployee;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractEmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContractEmployee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'file' => $this->faker->text(255),
            'from_date' => $this->faker->date,
            'until_date' => $this->faker->date,
            'nominal_guarantee' => $this->faker->randomNumber,
            'guarantee' => $this->faker->numberBetween(0, 127),
            'employee_id' => \App\Models\Employee::factory(),
        ];
    }
}
