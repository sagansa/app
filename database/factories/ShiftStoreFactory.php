<?php

namespace Database\Factories;

use App\Models\ShiftStore;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShiftStoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShiftStore::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique->text(50),
        ];
    }
}
