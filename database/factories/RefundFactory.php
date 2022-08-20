<?php

namespace Database\Factories;

use App\Models\Refund;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class RefundFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Refund::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
