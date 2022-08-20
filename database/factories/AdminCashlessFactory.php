<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\AdminCashless;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminCashlessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdminCashless::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->text(50),
            'email' => $this->faker->email,
            'no_telp' => $this->faker->randomNumber,
            'password' => $this->faker->password,
            'cashless_provider_id' => \App\Models\CashlessProvider::factory(),
        ];
    }
}
