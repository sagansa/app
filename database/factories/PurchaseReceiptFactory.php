<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\PurchaseReceipt;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseReceiptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseReceipt::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nominal_transfer' => $this->faker->randomNumber,
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
