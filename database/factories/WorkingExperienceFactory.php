<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\WorkingExperience;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkingExperienceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkingExperience::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'place' => $this->faker->text(255),
            'position' => $this->faker->text(255),
            'salary_per_month' => $this->faker->text(255),
            'previous_boss_name' => $this->faker->text(255),
            'previous_boss_no' => $this->faker->text(255),
            'from_date' => $this->faker->date,
            'until_date' => $this->faker->date,
            'reason' => $this->faker->text,
            'employee_id' => \App\Models\Employee::factory(),
        ];
    }
}
