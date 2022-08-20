<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\UserCashless;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserCashlessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserCashless::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->email,
            'username' => $this->faker->text(50),
            'password' => $this->faker->password,
            'no_telp' => $this->faker->randomNumber,
            'admin_cashless_id' => \App\Models\AdminCashless::factory(),
            'store_id' => \App\Models\Store::factory(),
        ];
    }
}
