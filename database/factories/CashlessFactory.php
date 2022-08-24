<?php

namespace Database\Factories;

use App\Models\Cashless;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashlessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cashless::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'bruto_apl' => $this->faker->randomNumber,
            'netto_apl' => $this->faker->randomNumber,
            'bruto_real' => $this->faker->randomNumber,
            'netto_real' => $this->faker->randomNumber,
            'image_canceled' => $this->faker->text(255),
            'canceled' => $this->faker->randomNumber(0),
            'closing_store_id' => \App\Models\ClosingStore::factory(),
            'account_cashless_id' => \App\Models\AccountCashless::factory(),
        ];
    }
}
