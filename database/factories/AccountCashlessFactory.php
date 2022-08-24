<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\AccountCashless;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountCashlessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccountCashless::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->email,
            'username' => $this->faker->text(255),
            'password' => $this->faker->password,
            'no_telp' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 2),
            'notes' => $this->faker->text,
            'cashless_provider_id' => \App\Models\CashlessProvider::factory(),
            'store_id' => \App\Models\Store::factory(),
            'store_cashless_id' => \App\Models\StoreCashless::factory(),
        ];
    }
}
