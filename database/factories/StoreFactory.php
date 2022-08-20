<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Store::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'nickname' => $this->faker->userName,
            'no_telp' => $this->faker->phoneNumber,
            'email' => $this->faker->unique->email,
            'status' => $this->faker->numberBetween(1, 4),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
