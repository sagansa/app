<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\VehicleCertificate;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleCertificateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VehicleCertificate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'BPKB' => $this->faker->numberBetween(1, 3),
            'STNK' => $this->faker->numberBetween(1, 3),
            'name' => $this->faker->name,
            'brand' => $this->faker->name,
            'type' => $this->faker->word,
            'category' => $this->faker->text(255),
            'model' => $this->faker->text(255),
            'manufacture_year' => $this->faker->year,
            'cylinder_capacity' => $this->faker->text(255),
            'vehilce_identity_no' => $this->faker->text(255),
            'engine_no' => $this->faker->text(255),
            'color' => $this->faker->hexcolor,
            'type_fuel' => $this->faker->text(255),
            'lisence_plate_color' => $this->faker->text(255),
            'registration_year' => $this->faker->text(255),
            'bpkb_no' => $this->faker->text(255),
            'location_code' => $this->faker->text(255),
            'registration_queue_no' => $this->faker->text(255),
            'notes' => $this->faker->text,
            'vehicle_id' => \App\Models\Vehicle::factory(),
        ];
    }
}
