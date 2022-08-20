<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ContractLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractLocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContractLocation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'file' => $this->faker->text(255),
            'address' => $this->faker->address,
            'codepos' => $this->faker->randomNumber(0),
            'gps_location' => $this->faker->text(255),
            'from_date' => $this->faker->date,
            'until_date' => $this->faker->date,
            'contact_person' => $this->faker->text(255),
            'no_contact_person' => $this->faker->text(255),
            'nominal_contract_per_year' => $this->faker->randomNumber,
            'store_id' => \App\Models\Store::factory(),
            'province_id' => \App\Models\Province::factory(),
            'regency_id' => \App\Models\Regency::factory(),
            'district_id' => \App\Models\District::factory(),
            'village_id' => \App\Models\Village::factory(),
        ];
    }
}
