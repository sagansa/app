<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SalesOrderEmployee;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesOrderEmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesOrderEmployee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'total' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'customer_id' => \App\Models\Customer::factory(),
            'delivery_address_id' => \App\Models\DeliveryAddress::factory(),
            'store_id' => \App\Models\Store::factory(),
            'created_by_id' => \App\Models\User::factory(),
            'approved_by_id' => \App\Models\User::factory(),
        ];
    }
}
