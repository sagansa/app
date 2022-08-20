<?php

namespace Database\Factories;

use App\Models\Presence;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PresenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Presence::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 2),
            'image_in' => $this->faker->text(255),
            'image_out' => $this->faker->text(255),
            'lat_long_in' => $this->faker->text(255),
            'lat_long_out' => $this->faker->text(255),
            'closing_store_id' => \App\Models\ClosingStore::factory(),
            'created_by_id' => \App\Models\User::factory(),
            'approved_by_id' => \App\Models\User::factory(),
            'payment_type_id' => \App\Models\PaymentType::factory(),
        ];
    }
}
