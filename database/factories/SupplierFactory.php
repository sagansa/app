<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'no_telp' => $this->faker->phoneNumber,
            'address' => $this->faker->text,
            'codepos' => $this->faker->randomNumber(5),
            'bank_account_name' => $this->faker->name,
            'bank_account_no' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 2),
            'province_id' => \App\Models\Province::factory(),
            'regency_id' => \App\Models\Regency::factory(),
            'district_id' => \App\Models\District::factory(),
            'village_id' => \App\Models\Village::factory(),
            'bank_id' => \App\Models\Bank::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
