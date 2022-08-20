<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'identity_no' => $this->faker->text(255),
            'fullname' => $this->faker->name,
            'nickname' => $this->faker->text(20),
            'no_telp' => $this->faker->randomNumber(),
            'birth_place' => $this->faker->text(255),
            'birth_date' => $this->faker->date,
            'gender' => $this->faker->numberBetween(0, 127),
            'religion' => $this->faker->numberBetween(0, 127),
            'marital_status' => $this->faker->numberBetween(0, 127),
            'level_of_education' => $this->faker->numberBetween(0, 127),
            'major' => $this->faker->text(255),
            'fathers_name' => $this->faker->text(255),
            'mothers_name' => $this->faker->text(255),
            'address' => $this->faker->text,
            'codepos' => $this->faker->randomNumber(0),
            'gps_location' => $this->faker->text(255),
            'parents_no_telp' => $this->faker->randomNumber(),
            'siblings_name' => $this->faker->text(255),
            'siblings_no_telp' => $this->faker->randomNumber(),
            'bpjs' => $this->faker->boolean,
            'driver_license' => $this->faker->text(255),
            'bank_account_no' => $this->faker->randomNumber(),
            'accepted_work_date' => $this->faker->date,
            'ttd' => $this->faker->text(255),
            'notes' => $this->faker->text,
            'image_identity_id' => $this->faker->text(255),
            'image_selfie' => $this->faker->text(255),
            'province_id' => \App\Models\Province::factory(),
            'regency_id' => \App\Models\Regency::factory(),
            'district_id' => \App\Models\District::factory(),
            'village_id' => \App\Models\Village::factory(),
            'bank_id' => \App\Models\Bank::factory(),
            'user_id' => \App\Models\User::factory(),
            'employee_status_id' => \App\Models\EmployeeStatus::factory(),
        ];
    }
}
