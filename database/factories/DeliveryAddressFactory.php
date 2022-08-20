<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DeliveryAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DeliveryAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'recipients_name' => $this->faker->text(255),
            'recipients_telp_no' => $this->faker->text(255),
            'address' => $this->faker->address,
            'codepos' => $this->faker->randomNumber(0),
            'gps_location' => $this->faker->text(255),
            'province_id' => \App\Models\Province::factory(),
            'regency_id' => \App\Models\Regency::factory(),
            'district_id' => \App\Models\District::factory(),
            'village_id' => \App\Models\Village::factory(),
            'customer_id' => \App\Models\Customer::factory(),
        ];
    }
}
