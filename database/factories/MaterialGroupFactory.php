<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\MaterialGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MaterialGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(50),
            'status' => $this->faker->numberBetween(1, 2),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
