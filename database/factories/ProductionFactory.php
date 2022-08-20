<?php

namespace Database\Factories;

use App\Models\Production;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Production::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'store_id' => \App\Models\Store::factory(),
            'created_by_id' => \App\Models\User::factory(),
            'approved_by_id' => \App\Models\User::factory(),
        ];
    }
}
