<?php

namespace Database\Factories;

use App\Models\VehicleTax;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleTaxFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VehicleTax::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount_tax' => $this->faker->randomNumber,
            'expired_date' => $this->faker->date,
            'notes' => $this->faker->text,
            'vehicle_id' => \App\Models\Vehicle::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
