<?php

namespace Database\Factories;

use App\Models\Sop;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SopFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sop::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'revision' => $this->faker->randomNumber(0),
            'file' => $this->faker->text(255),
        ];
    }
}
